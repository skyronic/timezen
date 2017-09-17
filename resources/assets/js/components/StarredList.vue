<template>
  <div>
    <div v-for="member in starred">
      <zone-display :name="member.name" :timezone="member.timezone"></zone-display>
    </div>
  </div>
</template>

<script>
  import ZoneDisplay from './ZoneDisplay.vue';

  export default {
    components: {
      ZoneDisplay
    },
    data () {
      return {
        starred: []
      }
    },
    mounted () {
      axios.get(`/user/starred_users`)
        .then((response) => {
          this.starred = response.data;
        })
    },
    methods: {

    },
    props: [

    ]
  };
</script>

<style lang="css">

</style>

