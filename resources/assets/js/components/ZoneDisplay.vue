<template>
  <div class="zone-display">
    <div>
      {{ name }} - {{ difference }} [{{ timezone }}]
    </div>
    <div class="zone-range">
      <div v-for="cell in zoneCells" class="zone-cell">

      </div>
    </div>
    <div class="zone-range">
      <div v-for="label in zoneLabels" class="zone-label">
        {{ label.time }}
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import moment from 'moment-timezone';
  export default {
    data () {
      return {
        zoneCells: [],
        zoneLabels: []
      }
    },
    mounted () {
      this.zoneLabels = _.map(_.range(0, 12), (v) => {
        let ts = moment().hour(v * 2).minute(0);
        return {
          time: ts.tz(this.timezone).format("hA")
        }
      })

      this.zoneCells = _.map(_.range(0, 48), (v) => {
        let ts = moment().hour(v * 2).minute(0);
        return {
          time: ts.tz(this.timezone).format("hA")
        }
      })
    },
    methods: {

    },
    computed: {

      difference () {
        let localOffset = moment.tz.zone(this.userTz).offset(moment.now());
        let zoneOffset = moment.tz.zone(this.timezone).offset(moment.now());

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
    },
    props: [
      'name',
      'timezone',
      'userTz'
    ]
  };
</script>

<style lang="css">
  .zone-display {
    border: 1px solid gray;
    height: 80px;
    width: 100%;
    margin-bottom: 15px;
    padding: 5px;
  }

  .zone-label{
    flex: 1;
  }
  .zone-cell{
    margin-right: 2px;
    height: 15px;
    border: 1px solid black;
    flex: 1;
  }

  .zone-range {
    display: flex;
    margin-top: 3px;

  }

</style>

