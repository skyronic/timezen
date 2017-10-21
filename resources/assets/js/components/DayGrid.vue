<template>
  <div>
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
  import { mapGetters, mapActions, mapState } from 'vuex';
  import { getDifference, getUpcoming, getSlotInfo, getCurrentSlot } from '../timeutils';
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

        let slotInfo = getSlotInfo(v, this.memberInfo, this.timezone, this.userTz);

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

        setTimeout(() => {
          // in case the mouseout isn't triggered
          this.resetCell()
        }, 5000)
      },
      resetCell () {
        this.setHighlightedCell(getCurrentSlot(this.userTz));
      }
    }),
    computed: Object.assign(mapState({
      activeCell: state => state.zoneui.highlightedCell
    }), {

    }),
    props: [
      'timezone',
      'memberInfo',
      'userTz'
    ]
  };
</script>

<style lang="scss">
  $red: #b71c1c;
  $orange: #FF5722;
  $green: #1B5E20;

  .zone-range {
    display: flex;
    margin-top: 3px;
  }

  .highlighted-cell {
    border-color: #000000 !important;
    border-style: solid;
    border-width: 2px;
  }

  .cell-not-available {
    background-color: $red;
  }
  .cell-not-ideal{
    background-color: $orange;
  }
  .cell-ideal{
    background-color: $green;
  }
  .zone-label{
    flex: 1;
  }
  .zone-cell{
    margin-right: 1px;
    border: 1px solid #fff;
    height: 14px;
    flex: 1;
  }

</style>

