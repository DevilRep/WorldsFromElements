import EventBus from '../eventBus';

export default {
    data: () => ({
        email: '',
        password: '',
        showPassword: false
    }),
    computed: {
        passwordIconClasses() {
            return {
                'fa-eye-slash': this.showPassword,
                'fa-eye': !this.showPassword
            };
        },
        passwordFieldType() {
            return this.showPassword ? 'text' : 'password';
        }
    },
    methods: {
        togglePassword() {
            this.showPassword = !this.showPassword;
        },
        isEmailValid() {
            let isNotValid = this.email.indexOf('@') < 0 || this.email.indexOf('.') < 0;
            if (isNotValid) {
                EventBus.$emit('modal:error:show', 'Please check your email')
            }
            return !isNotValid;
        },
        isPasswordValid() {
            let isNotValid = this.password.trim().length < 1;
            if (isNotValid) {
                EventBus.$emit('modal:error:show', 'Please enter your password')
            }
            return !isNotValid;
        },
        isPasswordLongEnough() {
            let isNotValid = this.password.trim().length < 6;
            if (isNotValid) {
                EventBus.$emit('modal:error:show', 'Password is too short')
            }
            return !isNotValid;
        }
    }
}