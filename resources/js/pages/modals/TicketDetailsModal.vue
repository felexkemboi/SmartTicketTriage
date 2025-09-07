<template>
	<div v-if="visible" class="modal-overlay">
		<div class="modal-content">
			<h2 class="modal-title">
				Ticket Details
			</h2>
			<form @submit.prevent="handleSubmit" class="form">
                <div class="form-group">
					<label>Subject:</label>
					{{ ticket.subject }}
				</div>
				<div class="form-group">
					<label>Category:</label>
                    {{ ticket.category }}
				</div>
				<div class="form-group">
					<label>Confidence:</label>
                    {{ ticket.confidence }}
				</div>
				<div class="form-group">
					<label>Note:</label>
					{{ ticket.subject }}
				</div>
				<div class="form-group">
					<label>Status:</label>
                    {{ ticket.status }}
				</div>

				<div class="actions">
					<button type="button" class="cancel-btn" @click="$emit('close')">Close</button>
					<button type="submit" class="save-btn">
						Classify 
					</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
import axios from "axios";

export default {
    name: "TicketModal",
    props: {
        visible: Boolean,
        ticket: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            activeTicket : {}
        };
    },
    methods: {
        async handleSubmit() {            
            // if (!this.validate()) return;
            // this.loading = true;
            // try {
            //     let res;
            //     if (this.mode === "create") {
            //         res = await axios.post("http://localhost:8000/api/tickets", this.form);
            //     } else {
            //         res = await axios.patch(`http://localhost:8000/api/tickets/${this.ticket.id}`, this.form);
            //     }
            //     this.$emit("save", res.data); 
        
            //     this.$emit("close");
            // } catch (error) {
            //     console.error("Failed to save ticket:", error);
            //     alert("Error saving ticket. Please try again.");
            // } finally {
            //     this.loading = false;
            // }
        },
    },
};
</script>
