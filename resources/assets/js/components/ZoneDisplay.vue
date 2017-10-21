<template>
  <div class="zone-display">
    <div>
      {{ name }} - {{ difference }} [{{ timezone }}]
    </div>
    <div v-if="memberInfo">
      Upcoming: {{ upcoming.message }}
    </div>
    <div class="cell-label">
      <div class="label-container" :style="labelStyle">
        {{ labelTime }}
      </div>
      <a href="#" @click="$emit('delete')">[Remove]</a>
    </div>
    <div class="zone-range">
      <div v-for="cell in zoneCells"
           @mouseover="onMouseOverCell(cell)"
           :class="[
             'zone-cell',
             cell.className,
             cell.index === activeCell ? 'highlighted-cell' : ''
            ]"
           >
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
  import { mapActions, mapGetters, mapState } from 'vuex'

  import { getDifference, getUpcoming, getSlotInfo } from '../timeutils';

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
      });

      this.zoneCells = _.map(_.range(0, 48), (v) => {
        let ts = moment().hour(0).minute(0).add(v*30, 'minutes').tz(this.timezone);

        let slotInfo = getSlotInfo(v, this.memberInfo);

        return {
          index: v,
          ts,
          className: slotInfo.class
        }
      })
    },
    methods: Object.assign(mapActions([
      'setHighlightedCell'

    ]), {
      onMouseOverCell (cell) {
        this.setHighlightedCell(cell.index);
      }
    }),
    computed: Object.assign(mapState({
      activeCell: state => state.zoneui.highlightedCell
    }), {
      labelTime () {
        let activeCell = this.zoneCells[this.activeCell];
        if(activeCell && activeCell.ts) {
          return activeCell.ts.format("h:mm A");
        }
        return "";
      },

      labelStyle () {
        if(this.activeCell < 3) {
          return {
            marginLeft: ((100 / 46) * this.activeCell) + "%"
          }
        }
        if(this.activeCell > 44) {
          return {
            marginLeft: ((100 / 46) * 42) + "%"
          }
        }
        else {
          return {
            marginLeft: ((100 / 46) * this.activeCell - 4) + "%"
          }
        }
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
        default: null
      }
    }
  };
</script>

<style lang="css">
  .zone-display {
    border: 1px solid gray;
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
  }

  .zone-label{
    flex: 1;
  }
  .zone-cell{
    margin-right: 2px;
    height: 15px;
    border: 1px solid #eee;
    flex: 1;
  }

  .zone-range {
    display: flex;
    margin-top: 3px;
  }

  .highlighted-cell {
    border-color: #000000;
    border-width: 2px;
  }

  .cell-not-available {
    background-color: red;
  }
  .cell-not-ideal{
    background-color: orange;
  }
  .cell-ideal{
    background-color: green;
  }

</style>

