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
        <td>
          <a class="btn btn-primary" v-if="!is_starred(member)" @click="toggleStar(member)">Star</a>
          <a class="btn btn-default" v-if="is_starred(member)" @click="toggleStar(member)">Un-Star</a>
        </td>
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
      axios.get(`/user/starred`)
        .then((response) => {
          this.starred_ids = response.data;
        })
    },
    methods: {
      is_starred(member) {
        return this.starred_ids.findIndex(x => x === member.id) !== -1;
      },
      toggleStar(member) {
        axios.post(`/user/toggle/${member.id}`)
          .then((response) => {
            this.starred_ids = response.data;
          })
      }
    },
    props: [
      'teamId',
      'isAdmin'
    ]
  };
</script>

<style lang="css">

</style>

