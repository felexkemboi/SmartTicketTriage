<template>
	<div class="app-container">
		<div class="topbar">
			<div class="tab" :class="{ active: activeTab === 'dashboard' }" @click="setActive('dashboard')"> Dashboard </div>
			<div class="tab" :class="{ active: activeTab === 'tickets' }" @click="setActive('tickets')"> Tickets </div>
		</div>

    </div>

	<div>
		<div v-if="activeTab === 'dashboard'">
			<dashboard />
		</div>
		<div v-if="activeTab === 'tickets'">
			<home />
		</div>
	</div>
</template>

<script>
import Home from "../Home.vue";
import Dashboard from "../Dashboard.vue";

export default {
    name: "App",
    components: {
        Dashboard,
        Home,
    },
    data() {
        return {
            activeTab: "tickets",
        };
    },
    methods: {
        setActive(tab) {
            this.activeTab = tab;
        },
    },
};
</script>


<style scoped>
    .topbar {
        display: flex;
        gap: 1rem;
    }
    .tab {
        padding: 0.5rem 1rem;
        cursor: pointer;
        text-decoration: none;
        color: #333;
    }
    .tab.active {
        font-weight: bold;
        border-bottom: 2px solid #007bff;
    }
</style>
