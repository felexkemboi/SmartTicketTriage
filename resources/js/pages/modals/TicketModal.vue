<template>
	<div v-if="visible" class="modal-overlay">
		<div class="modal-content">
			<h2 class="modal-title">
				{{ mode === 'create' ? 'Create Ticket' : 'Edit Ticket' }}
			</h2>
			<form @submit.prevent="handleSubmit" class="form">
				<div class="form-group">
					<label>Category</label>
					<select v-model="form.category" :class="{ 'input-error': errors.category }">
						<option disabled value="">Select category</option>
						<option>Billing</option>
						<option>Technical</option>
						<option>General</option>
						<option>Account</option>
						<option>Support</option>
					</select>
					<p v-if="errors.category" class="error">{{ errors.category }}</p>
				</div>
				<div class="form-group">
					<label>Confidence (0–1)</label>
					<input
						v-model.number="form.confidence"
						type="number"
						step="0.01"
						min="0"
						max="1"
						placeholder="0.85"
						:class="{ 'input-error': errors.confidence }"
					/>
					<p v-if="errors.confidence" class="error">{{ errors.confidence }}</p>
				</div>
				<div class="form-group">
					<label>Note</label>
					<textarea v-model="form.note" rows="3" placeholder="Add note here..."></textarea>
				</div>
				<div class="form-group">
					<label>Status</label>
					<select v-model="form.status" :class="{ 'input-error': errors.status }">
						<option disabled value="">Select status</option>
						<option>Open</option>
						<option>In Progress</option>
						<option>Closed</option>
					</select>
					<p v-if="errors.status" class="error">{{ errors.status }}</p>
				</div>

				<div class="actions">
					<button type="button" class="cancel-btn" @click="$emit('close')">Cancel</button>
					<button type="submit" class="save-btn">
						{{ mode === 'create' ? 'Save' : 'Update' }}
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
        mode: {
            type: String,
            default: "create",
        },
        ticket: {
            type: Object,
            default: null,
        },
    },
    emits: ["saved", "close"], 
    data() {
        return {
            form: {
                category: "",
                confidence: null,
                note: "",
                status: "",
            },
            errors: {
                category: "",
                confidence: "",
                status: "",
            },
            loading: false,
        };
    },
    watch: {
        visible(newVal) {
            if (newVal) {
                if (this.mode === "create") {
                    this.resetForm();
                } else if (this.ticket) {
                    this.form.category = this.ticket.category || "";
                    this.form.confidence = this.ticket.confidence ?? null;
                    this.form.note = this.ticket.note || "";
                    this.form.status = this.ticket.status || "";
                }
                this.errors = { category: "", confidence: "", status: "" };
            }
        },
    },
    methods: {
        resetForm() {
            this.form = {
                category: "",
                confidence: null,
                note: "",
                status: "",
            };
            this.errors = { category: "", confidence: "", status: "" };
        },
        validate() {
            let valid = true;

            if (!this.form.category) {
                this.errors.category = "Please select a category";
                valid = false;
            } else {
                this.errors.category = "";
            }

            if (
                this.form.confidence === null ||
                this.form.confidence === "" ||
                this.form.confidence < 0 ||
                this.form.confidence > 1
            ) {
                this.errors.confidence = "Confidence must be between 0 and 1";
                valid = false;
            } else {
                this.errors.confidence = "";
            }

            if (!this.form.status) {
                this.errors.status = "Please select a status";
                valid = false;
            } else {
                this.errors.status = "";
            }

            return valid;
        },
        async handleSubmit() {
            if (!this.validate()) return;
            this.loading = true;
            try {
                let res;
                if (this.mode === "create") {
                    res = await axios.post("http://localhost:8000/api/tickets", this.form);
                } else {
                    res = await axios.put(`http://localhost:8000/api/tickets/${this.ticket.id}`, this.form);
                }
                this.$emit("saved", res.data); 
                this.$emit("close");
            } catch (error) {
                console.error("Failed to save ticket:", error);
                alert("Error saving ticket. Please try again.");
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>
