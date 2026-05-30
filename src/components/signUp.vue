<script>
import { mapState } from 'vuex'
import { api } from "../lib/api";

export default {
    data: function() {
        return {
            // 'login' | 'signup-email' | 'signup-password'
            step: 'signup-email',
            transitionName: 'slide-next',
            email: '',
            password: '',
            confirmPassword: '',
            // Tracks whether each field has been "touched" (blurred at least once), so we don't show validation errors before the user has had a chance to type.
            touched: {
                email: false,
                password: false,
                confirmPassword: false
            },
            submitAttempted: false,
            // Stubbed feedback for the user after a (fake) successful submit.
            submitMessage: null,
            loginErr: null,
        }
    },
    computed: {
        ...mapState(['loggedIn', 'user']),
        emailValid: function() {
            // Email pattern; backend should do the real check.
            const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            return pattern.test(this.email.trim())
        },
        emailError: function() {
            if (!this.touched.email && !this.submitAttempted) return null
            if (this.email.trim() === '') return 'Email is required.'
            if (!this.emailValid) return 'Please enter a valid email address.'
            return null
        },
        passwordValid: function() {
            return this.password.length >= 8
        },
        passwordError: function() {
            if (!this.touched.password && !this.submitAttempted) return null
            if (this.password === '') return 'Password is required.'
            if (!this.passwordValid) return 'Password must be at least 8 characters.'
            return null
        },
        confirmPasswordError: function() {
            // Show mismatch warning live as the user types (no touched gate) but only flag "required" after blur or submit attempt.
            if (this.confirmPassword !== '' && this.confirmPassword !== this.password) {
                return 'Passwords do not match.'
            }
            if (!this.touched.confirmPassword && !this.submitAttempted) return null
            if (this.confirmPassword === '') return 'Please confirm your password.'
            return null
        },
        // Strength score 0-4 based on length + character variety.
        passwordStrength: function() {
            const pw = this.password
            if (pw.length === 0) return 0
            let score = 0
            if (pw.length >= 8) score++
            if (pw.length >= 12) score++
            if (/[A-Z]/.test(pw) && /[a-z]/.test(pw)) score++
            if (/\d/.test(pw) && /[^A-Za-z0-9]/.test(pw)) score++
            return score
        },
        passwordStrengthLabel: function() {
            return ['Too short', 'Weak', 'Fair', 'Good', 'Strong'][this.passwordStrength]
        },
        passwordStrengthClass: function() {
            // Maps strength to a Bootstrap progress-bar colour class.
            return [
                'bg-danger',
                'bg-danger',
                'bg-warning',
                'bg-info',
                'bg-success'
            ][this.passwordStrength]
        },
        passwordStrengthPercent: function() {
            return (this.passwordStrength / 4) * 100
        },
        // Form-level validity per step, used to disable the submit button.
        emailStepValid: function() {
            return this.emailValid
        },
        passwordStepValid: function() {
            return this.passwordValid
                && this.confirmPassword === this.password
                && this.confirmPassword !== ''
        },
        loginValid: function() {
            return this.emailValid && this.password !== ''
        }
    },
    watch: {
        // When the route changes (e.g. user clicks "Log In" link in navbar while already on this page), reset the view to match the route.
        '$route.name': {
            immediate: true,
            handler: function(name) {
                this.step = name === 'login' ? 'login' : 'signup-email'
                this.resetForm()
            }
        }
    },
    methods: {
        async newUser(username, email, password) {
            try {
                console.log(await api.newUser(username, email, password));
            }
            catch (err) {
                console.error("Failed to submit:", err);
            }
        },
        async callLogIn(username, password) {
            let userDetails = null
            try {
                userDetails = await api.getLogin(username, password);
            }
            catch (err) {
                console.error("Failed to load posts:", err);
            }
            if (userDetails && userDetails.length > 0) {
                this.$store.commit("logIn", userDetails[0]);
                this.loginErr = null;
            }
            else {
                this.loginErr = 'Invalid Username or Password'
            }
        },
        resetForm: function() {
            this.email = ''
            this.password = ''
            this.confirmPassword = ''
            this.touched = { email: false, password: false, confirmPassword: false }
            this.submitAttempted = false
            this.submitMessage = null
        },
        goToLogin: function() {
            this.transitionName = 'slide-prev'
            this.step = 'login'
            this.submitAttempted = false
            this.submitMessage = null
        },
        goToSignUp: function() {
            this.transitionName = 'slide-next'
            this.step = 'signup-email'
            this.submitAttempted = false
            this.submitMessage = null
        },
        proceedToPassword: function() {
            this.submitAttempted = true
            if (!this.emailStepValid) return
            this.transitionName = 'slide-next'
            this.step = 'signup-password'
            this.submitAttempted = false
        },
        backToEmail: function() {
            this.transitionName = 'slide-prev'
            this.step = 'signup-email'
            this.submitAttempted = false
        },
        submitSignUp: function() {
            this.submitAttempted = true
            if (!this.passwordStepValid) return
            // TODO: replace with POST to Mercury API once backend is ready. Ex: POST /api/users { email, password } -> { firstName, lastName, ... }
            const username = this.email.split('@')[0]
            this.newUser(username, this.email, this.password)
            this.callLogIn(username, this.password)
            this.submitMessage = 'Account created — welcome!'
            // Send the user to the home page once logged in.
            setTimeout(() => { this.$router.push({ name: 'home' }) }, 800)
        },
        submitLogIn: function() {
            this.submitAttempted = true
            if (!this.loginValid) return
            // TODO: replace with POST to Mercury API once backend is ready. Ex: POST /api/login { email, password } -> { firstName, lastName, ... }
            const username = this.email.split('@')[0]
            this.callLogIn(username, this.password)
            this.submitMessage = 'Welcome back!'
            setTimeout(() => { this.$router.push({ name: 'home' }) }, 800)
        }
    }
}
</script>

<template>
    <p>Sign Up - Placeholder</p>
</template>