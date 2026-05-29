<template>
<div class='container'>
<h3>Account Details</h3>
 <!-- Page when dets loaded-->
<div v-if="details.username && !isEditing">
    <v-text-field
        label="Account Username"
        v-model="details.username"
        readonly
    ></v-text-field>
    <v-text-field
        label="Account Email Address"
        v-model="details.email"
        readonly
    ></v-text-field>
    <v-text-field
        label="Account Password"
        v-model="details.password"
        type="password"
        readonly
    ></v-text-field>
     <v-text-field
        label="Time of Account creation"
        v-model="details.doc"
        readonly
    ></v-text-field>
    <v-text-field
        label="Account permissions"
        v-model="details.role"
        readonly
    ></v-text-field>
    <div class ="text-end">
        <button type="button" class="btn btn-primary" @click="isEditing = true">Change Details</button>
    </div>
</div>
 <!-- Page when editting dets, no functionality yet-->
<div v-if="details.username && isEditing">
    <v-text-field
        label="Account Username"
        v-model="editedDetails.username"
        
    ></v-text-field>
    <v-text-field
        label="Account Email Address"
        v-model="editedDetails.email"
        
    ></v-text-field>
    <v-text-field
        label="Account Password"
        v-model="editedDetails.password"
        type="password"
    ></v-text-field>
     <v-text-field
        label="Time of Account creation"
        v-model="details.doc"
        readonly
    ></v-text-field>
    <v-text-field
        label="Account permissions"
        v-model="details.role"
        readonly
    ></v-text-field>
    <div>
        <div class ="text-start">
            <button type="button" class="btn btn-warning" @click="cancelEdit">Revert changes</button>
        </div>
        <div class ="text-end">
            <button type="button" class="btn btn-success" @click="saveDetails">Success</button>
        </div>
    </div>

</div>
 <!-- Page when dets unloaded-->
<div v-if="!details.username">
  <p>Account details currently not available, please refresh page</p>
</div>
</div>
</template>

<script>
import { api } from "../lib/api";

export default {
    data() {
        return {
            details: {}, 
            editedDetails: {}, 
            isEditing: false,
        };
    },
    async mounted() {
        try {
            this.details = await api.accountget();
        } catch (err) {
            console.error("Failed to load user:", err);
        }
    },
    methods: {
        cancelEdit() {
            this.isEditing = false;
        },
        saveDetails() {
      // TODO: Call your update API here after adding form controls
            this.details = { ...this.editedDetails }; 
            this.isEditing = false;
        }
    },
    watch: {
        details(newVal) {
            this.editedDetails = { ...newVal };
        }
  }
};
</script>
