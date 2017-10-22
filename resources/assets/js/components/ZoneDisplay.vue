<template>
  <div class="zone-display">
    <div class="info-block">
      <div class="info-left">
        <div class="info-name">
          {{ name }}
        </div>
        <div class="info-upcoming">
          {{ upcoming.message }}
        </div>
      </div>
      <div class="info-right">
        <div class="info-tz">
          {{ difference }} [{{ timezone }}]
        </div>
      </div>
    </div>
    <div class="cell-block">
      <div :class="['time-label', 'text-label-' + activeColorCode]">
        {{ labelTime }}
      </div>
      <div class="cell-range">
        <day-grid :timezone="timezone"
        :user-tz="userTz"
        :member-info="memberInfo"></day-grid>

      </div>
    </div>
  </div>
</template>

<script>
  import { mapActions, mapGetters, mapState } from 'vuex'

  import { getDifference,
    getUpcoming,
    getSlotInfo,
    getTimeForSlot,
    getColorCodeForSlot,
    getCurrentSlot } from '../timeutils';

  import _ from 'lodash';
  import moment from 'moment-timezone';
  import DayGrid from './DayGrid.vue'
  export default {
    data () {
      return {
      }
    },
    components: {
      DayGrid
    },
    mounted () {
    },
    methods: {

    },
    computed: Object.assign(mapState({
      activeCell: state => state.zoneui.highlightedCell
    }), {
      labelTime () {
        return getTimeForSlot(this.activeCell, this.timezone, this.userTz);
      },

      activeColorCode () {
        return getColorCodeForSlot(this.activeCell, this.memberInfo, this.timezone, this.userTz);

      },

      difference () {
        return getDifference(this.userTz, this.timezone)
      },

      upcoming () {
        if(this.memberInfo) {
          return getUpcoming(this.memberInfo, this.timezone, this.userTz)
        }
        else {
          return {
            message: "Unknown..."
          }
        }
      }
    }),
    props: {
      'name': String,
      timezone: null,
      userTz: null,
      memberInfo: {
        type: null,
        default: () => {
          return {
            day_start: 16,
            ideal_start: 20,
            ideal_end: 32,
            day_end: 38
          }
        }
      }
    }
  };
</script>

<style lang="scss">
  $red: #b71c1c;
  $orange: #FF5722;
  $green: #1B5E20;


  .zone-display {
    border-bottom: 1px solid #eee;
    border-top: 1px solid #eee;
    border-right: 1px solid #eee;
    width: 100%;
    border-left: 3px solid $red;
    height: 110px;
    padding: 5px 10px;
  }

  .zone-border-red {
    border-left: 3px solid $red;
  }
  .zone-border-orange{
    border-left: 3px solid $orange;
  }
  .zone-border-green {
    border-left: 3px solid $green;
  }

  .text-label-red {
    color: $red;
  }
  .text-label-orange {
    color: $orange;
  }
  .text-label-green {
    color: $green;
  }

  .info-block {
    display: flex;
  }

  .info-left {
    flex: 1;
  }
  .info-right {

  }

  .info-name {
    font-size: 20px;
    line-height: 22px;
    margin-top: 5px;
    color: #333;
  }

  .info-upcoming {
    color: #555;
  }

  .info-tz {
    margin-top: 4px;
    font-size: 12px;
    color: #aaa;
  }


  .cell-block {
    display: flex;
    margin-top: 5px;
  }

  .time-label {
    width: 100px;
    font-size: 18px;
  }

  .cell-range {
    width: 100%;
  }

</style>

