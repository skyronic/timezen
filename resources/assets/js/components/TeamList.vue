<template>
  <div>
    <table class="table table-striped">
      <thead>

      <tr>
      <th>Name</th>
      <th>Star</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="member in members">
        <td>{{ member.name }}</td>
        <td></td>
      </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
  import axios from 'axios';

  export default {
    data () {
      return {
        members: [],
        starred_ids: []
      }
    },
    mounted() {
      axios.get(`/team/list/${this.teamId}`)
        .then((response) => {
          this.members = response.data;
        })
    },
    methods: {

    },
    props: [
      'teamId'
    ]
  };
</script>

<style lang="css">

</style>

