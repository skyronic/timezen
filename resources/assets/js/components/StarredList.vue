<template>
  <div>
    <div>
      <zone-display name="You!" :timezone="userTz" :user-tz="userTz"></zone-display>
    </div>
    <div v-for="member in starred">
      <zone-display :name="member.name"
                    :timezone="member.timezone"
                    :user-tz="userTz"
                    @delete="removeMember(member)"></zone-display>
    </div>
    <div v-for="item in customList">
      <zone-display :name="item.name" :timezone="item.timezone" :user-tz="userTz" @delete="removeCustom(item)"></zone-display>
    </div>
  </div>
</template>

<script>
  import ZoneDisplay from './ZoneDisplay.vue';
  import moment from 'moment-timezone';

  export default {
    components: {
      ZoneDisplay
    },
    data () {
      return {
        starred: [],
        customList: [],
        userTz: "UTC"
      }
    },
    mounted () {
      this.userTz = moment.tz.guess();

      axios.get(`/user/starred_users`)
        .then((response) => {
          this.starred = response.data;
        })
      axios.get(`/user/custom_items`)
        .then((response) => {
          this.customList = response.data;
        })
    },
    methods: {
      removeMember(member) {
        axios.post(`/user/remove_starred/${member.id}`)
          .then((response) => {
            this.starred = this.starred.filter(x => x.id !== member.id);
          })
      },
      removeCustom (custom) {
        axios.post(`/user/remove_custom/${custom.id}`)
          .then((response) => {
            this.customList= this.customList.filter(x => x.id !== custom.id);
          })
      }
    },
    props: [

    ]
  };
</script>

<style lang="css">

</style>

