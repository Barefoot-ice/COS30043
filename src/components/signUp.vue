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
            if (!this.touched.confirmPassword && !this.submitAttempted) return null
            if (this.confirmPassword === '') return 'Please confirm your password.'
            if (this.confirmPassword !== this.password) return 'Passwords do not match.'
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
    <div class="container py-5 justify-content-center">
        <div class="row">
            <div class="col">

                <!-- If already logged in, show a friendly message instead of the form. -->
                <div v-if="loggedIn" class="card shadow-sm">
                    <div class="card-body text-center p-4">
                        <h5 class="card-title mb-3">You're already logged in</h5>
                        <p class="card-text mb-4">Welcome back, {{ user.firstName }}!</p>
                        <router-link class="btn btn-primary" to="/home">Go to Home</router-link>
                    </div>
                </div>

                <div v-else class="card shadow-sm" >
                    <div class="card-body p-4">

                        <!-- Animated step transitions: slide left/right depending on direction. -->
                        <transition :name="transitionName" mode="out-in">
                            <!-- STEP: LOG IN -->
                            <div v-if="step === 'login'" key="login">
                                <h4 class="card-title mb-1">Log In</h4>
                                <p class="text-body-secondary mb-4">Welcome back. Please enter your details.</p>

                                <div class="mb-3">
                                    <label for="login-email" class="form-label">Email</label>
                                    <input
                                        id="login-email"
                                        type="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': emailError }"
                                        v-model="email"
                                        @blur="touched.email = true"
                                        placeholder="you@example.com"
                                        autocomplete="email" />
                                    <div v-if="emailError" class="invalid-feedback">{{ emailError }}</div>
                                </div>

                                <div class="mb-3">
                                    <label for="login-password" class="form-label">Password</label>
                                    <input
                                        id="login-password"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': submitAttempted && password === '' }"
                                        v-model="password"
                                        @blur="touched.password = true"
                                        @keyup.enter="submitLogIn"
                                        placeholder="Enter your password"
                                        autocomplete="current-password" />
                                    <div v-if="submitAttempted && password === ''" class="invalid-feedback">
                                        Password is required.
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-primary w-100 mb-3"
                                    @click="submitLogIn">
                                    Log In
                                </button>

                                <p v-if="submitMessage" class="text-success text-center mb-2">{{ submitMessage }}</p>

                                <p class="text-center mb-0">
                                    Don't have an account?
                                    <a href="#" @click.prevent="goToSignUp">Sign Up</a>
                                </p>
                            </div>
                            <!-- STEP: SIGN-UP, STEP 1 (EMAIL) -->
                            <div v-else-if="step === 'signup-email'" key="signup-email">
                                <h4 class="card-title mb-1">Create Account</h4>
                                <p class="text-body-secondary mb-4">Step 1 of 2 — enter your email to get started.</p>

                                <div class="mb-3">
                                    <label for="signup-email" class="form-label">Email</label>
                                    <input
                                        id="signup-email"
                                        type="email"
                                        class="form-control"
                                        :class="{ 'is-invalid': emailError }"
                                        v-model="email"
                                        @blur="touched.email = true"
                                        @keyup.enter="proceedToPassword"
                                        placeholder="you@example.com"
                                        autocomplete="email" />
                                    <div v-if="emailError" class="invalid-feedback">{{ emailError }}</div>
                                </div>

                                <button
                                    type="button"
                                    class="btn btn-primary w-100 mb-3"
                                    @click="proceedToPassword">
                                    Create Account
                                </button>

                                <p class="text-center mb-0">
                                    Already have an account?
                                    <a href="#" @click.prevent="goToLogin">Log In</a>
                                </p>
                            </div>
                            <!-- STEP: SIGN-UP, STEP 2 (PASSWORD) -->
                            <div v-else-if="step === 'signup-password'" key="signup-password">
                                <h4 class="card-title mb-1">Create Password</h4>
                                <p class="text-body-secondary mb-4">
                                    Step 2 of 2 — secure your account for <strong>{{ email }}</strong>.
                                </p>

                                <div class="mb-3">
                                    <label for="signup-password" class="form-label">Password</label>
                                    <input
                                        id="signup-password"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': passwordError }"
                                        v-model="password"
                                        @blur="touched.password = true"
                                        placeholder="At least 8 characters"
                                        autocomplete="new-password" />
                                    <div v-if="passwordError" class="invalid-feedback">{{ passwordError }}</div>

                                    <!-- Password strength meter -->
                                    <div v-if="password.length > 0" class="mt-2">
                                        <div class="progress" style="height: 6px;">
                                            <div
                                                class="progress-bar"
                                                :class="passwordStrengthClass"
                                                role="progressbar"
                                                :style="{ width: passwordStrengthPercent + '%' }"
                                                :aria-valuenow="passwordStrength"
                                                aria-valuemin="0"
                                                aria-valuemax="4">
                                            </div>
                                        </div>
                                        <small class="text-body-secondary">Strength: {{ passwordStrengthLabel }}</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="signup-confirm" class="form-label">Confirm Password</label>
                                    <input
                                        id="signup-confirm"
                                        type="password"
                                        class="form-control"
                                        :class="{ 'is-invalid': confirmPasswordError }"
                                        v-model="confirmPassword"
                                        @blur="touched.confirmPassword = true"
                                        @keyup.enter="submitSignUp"
                                        placeholder="Re-enter your password"
                                        autocomplete="new-password" />
                                    <div v-if="confirmPasswordError" class="invalid-feedback">{{ confirmPasswordError }}</div>
                                </div>

                                <div class="d-flex gap-2 mb-3">
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary flex-fill"
                                        @click="backToEmail">
                                        Back
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-primary flex-fill"
                                        @click="submitSignUp">
                                        Sign Up
                                    </button>
                                </div>

                                <p v-if="submitMessage" class="text-success text-center mb-0">{{ submitMessage }}</p>
                            </div>

                        </transition>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
/* Slide-forward (next step): new view enters from the right, old view exits left. */
.slide-next-enter-active,
.slide-next-leave-active,
.slide-prev-enter-active,
.slide-prev-leave-active {
    transition: opacity 0.25s ease, transform 0.25s ease;
}

.slide-next-enter-from {
    opacity: 0;
    transform: translateX(30px);
}
.slide-next-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}

/* Slide-back (previous step): mirror direction. */
.slide-prev-enter-from {
    opacity: 0;
    transform: translateX(-30px);
}
.slide-prev-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
