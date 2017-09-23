<template>
  <div class="zone-display">
    <div>
      {{ name }} - {{ difference }} [{{ timezone }}]
    </div>
    <div class="cell-label">
      <div class="label-container" :style="labelStyle">
        {{ labelTime }}

      </div>
    </div>
    <div class="zone-range">
      <div v-for="cell in zoneCells" class="zone-cell" @mouseover="onMouseOverCell(cell)"
           :class="cell.index === activeCell ? 'highlighted-cell' : ''">
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

        return {
          index: v,
          ts
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
    }),
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
    height: 100px;
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

  .highlighted-cell {
    background-color: blue;
  }

</style>

