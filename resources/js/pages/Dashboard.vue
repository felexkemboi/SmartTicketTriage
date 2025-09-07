<template>
	<div :class="['dashboard', darkMode ? 'dark' : 'light']">
		<header class="dashboard-header">
			<h1>📊 Dashboard</h1>
		</header>
		<section class="cards">
			<div v-for="(count, status) in ticketStatusCounts" :key="status" class="card">
				<h2>{{ status }}</h2>
				<p class="count">{{ count }}</p>
			</div>
			<div v-for="(count, category) in ticketCategoryCounts" :key="category" class="card">
				<h2>{{ category }}</h2>
				<p class="count">{{ count }}</p>
			</div>
		</section>
		<section class="chart-card">
			<h2>Tickets by Category</h2>
			<canvas id="ticketsChart"></canvas>
		</section>
	</div>
</template>

<script>
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);

export default {
    name: "DashboardPage",
    data() {
        return {
        darkMode: false,
        tickets: [
            { status: "open", category: "Billing" },
            { status: "closed", category: "Technical" },
            { status: "open", category: "Billing" },
            { status: "pending", category: "General" },
            { status: "closed", category: "Billing" },
        ],
        chart: null,
        };
    },
    computed: {
        ticketStatusCounts() {
            return this.tickets.reduce((acc, t) => {
                acc[t.status] = (acc[t.status] || 0) + 1;
                return acc;
            }, {});
        },
        ticketCategoryCounts() {
            return this.tickets.reduce((acc, t) => {
                acc[t.category] = (acc[t.category] || 0) + 1;
                return acc;
            }, {});
        },
    },
    methods: {
        toggleTheme() {
            this.darkMode = !this.darkMode;
            this.renderChart();
        },
        renderChart() {
        const ctx = document.getElementById("ticketsChart").getContext("2d");

        if (this.chart) {
            this.chart.destroy();
        }

        this.chart = new Chart(ctx, {
            type: "pie",
            data: {
            labels: Object.keys(this.ticketCategoryCounts),
            datasets: [
                {
                    data: Object.values(this.ticketCategoryCounts),
                    backgroundColor: [
                        "#3b82f6",
                        "#10b981",
                        "#f59e0b",
                        "#ef4444",
                        "#8b5cf6",
                    ],
                },
            ],
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: this.darkMode ? "#f3f4f6" : "#1f2937",
                        },
                    },
                },
            },
        });
        },
    },
    mounted() {
        this.renderChart();
    },
};
</script>
