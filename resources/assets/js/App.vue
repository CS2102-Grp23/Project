<template>
  <div>
    <header-bar></header-bar>
		<alerts :alerts="alerts"></alerts>
    <router-view></router-view>
  </div>
</template>

<script>
	import Alerts from './components/Alerts';
  import HeaderBar from './components/HeaderBar';
  
  export default {
    components: {
			Alerts,
      HeaderBar,
    },
		data() {
      return {
        alerts: [],
      };
    },
		methods: {
			alert: function displayAlert(alert) {
        this.alerts.push(alert);
        setTimeout(() => {
          this.alerts = this.alerts.filter(function (item) {
            return alert.message !== item.message;
          })
        }, alert.duration || 3000);
      },
			search: function search(searchText) {
				this.$eventHub.$emit('queryProjects', searchText);
			},
		},
    created: function () {
      this.$eventHub.$on('search', this.search);
      this.$eventHub.$on('alert', this.alert);
    },
  };
</script>
