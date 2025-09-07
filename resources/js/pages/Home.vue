<template>
	<div class="ticket-page">
		<div class="header">
			<h1 class="title">Support Tickets</h1>
			<p class="description">Manage and classify support tickets easily.</p>
			<div class="actions-group">
				<button class="add-btn" @click="openCreate">+ Add Ticket</button>
				<button class="export-btn" @click="exportCSV">Export CSV</button>
			</div>
		</div>

		<div class="search-bar">
			<input v-model="searchQuery" type="text" placeholder="Search tickets..." />

			<select v-model="selectedStatus">
				<option value="">All Status</option>
				<option value="open">Open</option>
				<option value="pending">In Progress</option>
				<option value="closed">Closed</option>
			</select>

			<select v-model="selectedCategory">
				<option value="">All Categories</option>
				<option value="Feedback">Feedback</option>
				<option value="Inquiries">Inquiries</option>
				<option value="Appointment">Appointment</option>
				<option value="Technical">Technical</option>
				<option value="Billing">Billing</option>
			</select>
		</div>

		<div class="ticket-list">
			<div v-for="(ticket, index) in paginatedTickets" :key="index" class="ticket-card">
				<div class="card-header">
					<span class="category">{{ ticket.category }}</span>
					<div class="header-actions">
						<span v-if="ticket.body" class="badge tooltip">
							Note <span class="tooltip-text">{{ ticket.body }}</span>
						</span>
						<div class="edit-icon">
							<svg @click.stop="openEdit(ticket, index)" xmlns="http://www.w3.org/2000/svg" 
								fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
								class="w-6 h-6 cursor-pointer hover:text-blue-500 transition">
								<path stroke-linecap="round" stroke-linejoin="round" 
									d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 
									2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 
									1.13L6 18l.8-2.685a4.5 4.5 0 0 1 
									1.13-1.897l8.932-8.931Zm0 0L19.5 
									7.125M18 14v4.75A2.25 2.25 0 0 1 
									15.75 21H5.25A2.25 2.25 0 0 1 
									3 18.75V8.25A2.25 2.25 0 0 1 
									5.25 6H10" />
							</svg>
						</div>					
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<label>Confidence:</label>
						<span>{{ ticket.confidence }}</span>
					</div>
					<div class="row">
						<label>Status:</label>
						<span class="status" :class="ticket.status.toLowerCase().replace(/\s+/g, '-')">
							{{ ticket.status }}
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="pagination">
			<button :disabled="currentPage === 1" @click="currentPage--"> Prev </button>
			<span v-for="page in totalPages" :key="page">
				<button @click="goToPage(page)" :class="{ active: currentPage === page }">
					{{ page }}
				</button>
			</span>
			<button :disabled="currentPage === totalPages" @click="currentPage++"> Next </button>
		</div>

		<TicketModal 
			:visible="modalVisible" 
			:mode="modalMode" 
			:ticket="selectedTicket" 
			@save="handleSave" 
			@close="modalVisible = false" 
		/>
	</div>
</template>

<script>
import axios from "axios";
import TicketModal from "./modals/TicketModal.vue";

export default {
    name: "TicketListPage",
    components: { TicketModal },
    data() {
        return {
            tickets: [],
            searchQuery: "",
            selectedStatus: "",
            selectedCategory: "",
            currentPage: 1,
            itemsPerPage: 15,
            modalVisible: false,
            modalMode: "create",
            selectedTicket: null,
            editIndex: null,
        };
    },
    computed: {
        filteredTickets() {

            let results = this.tickets;

            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                results = results.filter(ticket =>
                    ticket.category.toLowerCase().includes(query) ||
                    ticket.body.toLowerCase().includes(query) ||
                    ticket.status.toLowerCase().includes(query)
                );
            }

            if (this.selectedStatus) {
                results = results.filter(ticket => ticket.status === this.selectedStatus);
            }

            if (this.selectedCategory) {
                results = results.filter(ticket => ticket.category === this.selectedCategory);
            }

            return results;
        },
        totalPages() {
            return Math.ceil(this.filteredTickets.length / this.itemsPerPage) || 1;
        },
        paginatedTickets() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredTickets.slice(start, start + this.itemsPerPage);
        },
    },
    methods: {
        async fetchTickets() {
            try {
                const res = await axios.get("http://localhost:8000/api/tickets");
                console.log(res.data)
                this.tickets = res.data.data || res.data; 
            } catch (err) {
                console.error("Failed to load tickets", err);
            }
        },

        openCreate() {
            this.modalMode = "create";
            this.selectedTicket = null;
            this.modalVisible = true;
        },
        openEdit(ticket, index) {
            this.modalMode = "edit";
            this.selectedTicket = { ...ticket };
            this.editIndex = index;
            this.modalVisible = true;
            this.openMenuIndex = null;
        },
        handleSave(newTicket) {
            if (this.modalMode === "create") {
                this.tickets.push(newTicket);
            } else if (this.modalMode === "edit" && this.editIndex !== null) {
                this.tickets.splice(this.editIndex, 1, newTicket);
            }
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        exportCSV() {
            const headers = ["Category", "Confidence", "Note", "Status"];
            const rows = this.filteredTickets.map(t => [
                t.category,
                t.confidence,
                t.body || "",
                t.status
            ]);

            let csvContent = [headers, ...rows]
                .map(row => row.map(value => `"${String(value).replace(/"/g, '""')}"`).join(","))
                .join("\n");

            const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });
            const link = document.createElement("a");
            link.href = URL.createObjectURL(blob);
            link.setAttribute("download", "tickets.csv");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    },
    watch: {
        searchQuery() {
            this.currentPage = 1; 
        },
        selectedStatus() {
            this.currentPage = 1;
        },
        selectedCategory() {
            this.currentPage = 1;
        },
    },
    mounted() {
        this.fetchTickets();
    },
};
</script>