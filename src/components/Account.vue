<template>
  <!-- v-container acts like Bootstrap's container class -->
  <v-container class="mt-4">
    <h3 class="text-center mb-4 font-weight-bold text-h5">Account Details</h3>

    <!-- ================= VIEW MODE ================= -->
    <v-row v-if="details.username && !isEditing" class="g-3">
      <v-col cols="12" md="6" lg="4">
        <v-text-field
          label="Account Username"
          v-model="details.username"
          readonly
          variant="outlined"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6" lg="4">
        <v-text-field
          label="Account Email Address"
          v-model="details.email"
          readonly
          variant="outlined"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6" lg="4">
        <v-text-field
          label="Account Password"
          v-model="details.password"
          type="password"
          readonly
          variant="outlined"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <v-text-field
          label="Time of Account creation"
          v-model="details.created_at"
          readonly
          variant="outlined"
        ></v-text-field>
      </v-col>

      <v-col cols="12" md="6">
        <v-text-field
          label="Account permissions"
          v-model="details.role"
          readonly
          variant="outlined"
        ></v-text-field>
      </v-col>

      <v-col cols="12" class="text-end mt-2">
        <v-btn color="primary" class="px-6" @click="startEdit">Change Details</v-btn>
      </v-col>
    </v-row>

    <!-- ================= EDIT MODE WITH FORM CONTROLS ================= -->
    <!-- ref="form" registers the component instance so we can programmatically check validity -->
    <v-form v-if="details.username && isEditing" ref="accountForm" @submit.prevent="saveDetails">
      <v-row class="g-3">
        
        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Account Username"
            v-model.trim="editedDetails.username"
            :rules="usernameRules"
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Account Email Address"
            v-model.trim="editedDetails.email"
            :rules="emailRules"
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Account Password"
            v-model="editedDetails.password"
            :rules="passwordRules"
            type="password"
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Confirm Password"
            v-model="confirmationPassword"
            :rules="confirmPasswordRules"
            type="password"
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Time of Account creation"
            v-model="details.created_at"
            readonly
            disabled
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" md="6" lg="4">
          <v-text-field
            label="Account permissions"
            v-model="details.role"
            readonly
            disabled
            variant="outlined"
          ></v-text-field>
        </v-col>

        <v-col cols="12" class="d-flex justify-content-between mt-4">
          <v-btn color="warning" class="px-6" @click="cancelEdit">Revert changes</v-btn>
          <v-btn type="submit" color="success" class="px-6">Save Changes</v-btn>
        </v-col>
      </v-row>
    </v-form>

    <!-- ================= UNLOADED/ERROR MODE ================= -->
    <div v-if="!details.username" class="text-center py-5">
      <p class="text-muted">Account details currently not available, please refresh page.</p>
    </div>
  </v-container>
</template>

<script>
import { api } from "../lib/api";

export default {
    data() {
        return {
            details: {}, 
            editedDetails: {}, 
            confirmationPassword: "",
            isEditing: false,

            // VUETIFY VALIDATION RULES
            // Rules are arrays of functions that return true or an error string
            usernameRules: [
                v => !!v || 'Username is required',
                v => (v && v.trim().length > 0) || 'Username cannot be blank'
            ],
            emailRules: [
                v => !!v || 'Email address is required',
                v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) || 'Must be a valid email address layout'
            ],
            passwordRules: [
                v => !!v || 'Password is required',
                v => (v && v.length >= 8) || 'Password must be 8 or more characters in length'
            ],
            confirmPasswordRules: [
                v => !!v || 'Please confirm your password',
                v => v === this.editedDetails.password || 'Passwords do not match!'
            ]
        };
    },
    computed: {
        currentUserId() {
            return this.$store.getters.userId;
        }
    },
    async mounted() {
        try {
            if (this.currentUserId) {
                this.details = await api.getAccount(this.currentUserId);
            } else {
                console.warn("No user is currently logged in.");
                this.$router.push('/'); 
            }
        } catch (err) {
            console.error("Failed to load user:", err);
        }
    },
    methods: {
        startEdit() {
            this.editedDetails = { ...this.details };
            this.confirmationPassword = this.details.password;
            this.isEditing = true;
        },
        cancelEdit() {
            this.isEditing = false;
        },
        async saveDetails() {
            // 1. Ask Vuetify to run all validation rules against the fields
            const { valid } = await this.$refs.accountForm.validate();

            // 2. If any input is failing validation, exit immediately
            if (!valid) {
                return;
            }

            try {
                // 3. Trigger api.js backend payload update
                const result = await api.editAccount(
                    this.currentUserId,
                    this.editedDetails.username,
                    this.editedDetails.email,
                    this.editedDetails.password
                );
                if (result.ok) { 
                    this.details = { ...this.editedDetails }; 
                    this.$store.commit('logIn', this.details);
                    this.isEditing = false;
                    alert("Account details successfully updated!");
                } else {
                    alert("Server refused to save changes. Please try again.");
                }
            } catch (err) {
                console.error("Failed to update account on server:", err);
            }
        },
    }
};
</script>
<style scoped>
/* Force outer component container padding constraints */
.v-container {
  padding-left: 24px !important;
  padding-right: 24px !important;
  max-width: 1200px !important; /* Prevents the fields stretching infinitely wide on big monitors */
  margin-left: auto !important;
  margin-right: auto !important;
}

/* Adds horizontal padding buffer spacing within columns */
.v-col {
  padding-left: 12px !important;
  padding-right: 12px !important;
}
</style>
