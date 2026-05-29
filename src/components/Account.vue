<template>
<div class='container'>
<h3>Account Details</h3>
<div>
    <!-- static account details pag
    todo: and an on button event to change usrname, pass and email fields to changeable and use same controls as signup then send put req on new button that appears after changing to edit, add a cancel changes button too-->
    <p>Account Username: {{ details.username }}</p>
    <p>Account Email Address: {{ details.email }}</p>
    <p>Account Password: {{ details.password }}</p>
    <p>Date of account creation: {{ details.doc }}</p>
    <p>Account permissions: {{ details.role }}</p>
</div>
</div>
</template>

<script>
import { api } from "../lib/api";

export default {
    data() {
        return {
            details: {}, 
        };
    },
    async mounted() {
        try {
            this.details = await api.accountget();
        } catch (err) {
            console.error("Failed to load user:", err);
        }
    },
};
</script>
