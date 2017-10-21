import moment from 'moment-timezone'

const timeTo = (slot, targetTz, userTz) => {
  // get the current time in the target timezone
  let targetTimeStamp = moment.tz(targetTz);

  // move the clock to start of the day
  targetTimeStamp.startOf('day');

  // add the minutes for the slot
  targetTimeStamp.add(slot * 30, 'minutes');

  // convert that to the local time
  return targetTimeStamp.clone().tz(userTz);
};

export const getUpcoming = (memberConfig, timezone, userTz) => {
  // get the local time in the target tz
  let memberTime = moment().tz(timezone);

  // number of minutes elapsed in day
  let elapsedCount = (memberTime.hours() * 60 + memberTime.minutes ()) / 30;

  let response = {};
  let { ideal_start, day_start, ideal_end, day_end } = memberConfig;

  if (elapsedCount >= day_end || elapsedCount < day_start) {
    let target_start = day_start;
    if(elapsedCount >= day_end) {
      // ensure that start of day is tomorrow
      target_start = parseInt(target_start) + 48
    }
    let eventTime = timeTo(target_start, timezone, userTz);
    response = {
      message: "Day Start " + eventTime.fromNow()
    }
  } else if (elapsedCount < ideal_start) {
    let eventTime = timeTo(ideal_start, timezone, userTz);
    response = {
      message: "Ideal Start " + eventTime.fromNow()
    }

  } else if (elapsedCount < ideal_end) {
    let eventTime = timeTo(ideal_end, timezone, userTz);
    response = {
      message: "Ideal End " + eventTime.fromNow()
    }
  } else if (elapsedCount < day_end ) {
    let eventTime = timeTo(ideal_end, timezone, userTz);
    response = {
      message: "Day End " + eventTime.fromNow()
    }
  }

  return response;
};

export const getSlotInfo = (slot, memberConfig) => {
  let response = {};
  if(memberConfig === null) {
    return {
      color: 'white'
    };
  }
  let { ideal_start, day_start, ideal_end, day_end } = memberConfig;


  if (slot >= day_end || slot < day_start) {
    response = {
      class: "cell-not-available"
    }
  } else if (slot < ideal_start) {
    response = {
      class: "cell-not-ideal"
    }

  } else if (slot < ideal_end) {
    response = {
      class: "cell-ideal"
    }
  } else if (slot < day_end ) {
    response = {
      class: "cell-not-ideal"
    }
  }

  return response;
}

export const getColorCodeForSlot = (slot, memberConfig) => {
  let { ideal_start, day_start, ideal_end, day_end } = memberConfig;


  if (slot >= day_end || slot < day_start) {
    return 'red';
  } else if (slot < ideal_start) {
    return 'orange';
  } else if (slot < ideal_end) {
    return 'green';
  } else if (slot < day_end ) {
    return 'red'
  }
}

export const getDifference = (userTz, timezone) => {
  let localOffset = moment.tz.zone(userTz).offset(moment.now());
  let zoneOffset = moment.tz.zone(timezone).offset(moment.now());

  if(zoneOffset === localOffset) {
    return "No difference";
  }

  let direction = "ahead";
  let diff_minutes = localOffset - zoneOffset;
  if (zoneOffset > localOffset) {
    direction = "behind";
    diff_minutes = zoneOffset - localOffset;
  }

  diff_minutes = Math.abs(diff_minutes);
  let diff_hours = Math.round(diff_minutes / 60)

  return `${diff_hours} hrs ${direction}`;

}

export const getCurrentSlot = (userTz) => {
  let current = moment.tz(userTz)
  let minutes = current.hours() * 60 + current.minutes();
  return Math.floor(minutes / 30)
}

// TODO: this is wrong and needs to be fixed
export const getTimeForSlot = (slot, timezone, userTz) => {
  let targetTimestamp = moment.tz(timezone)
  return targetTimestamp.startOf('day')
    .add(30 * slot, 'minutes')
    .clone()
    .tz(userTz)
    .format('h:mm A');
};
