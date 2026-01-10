<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, onMounted, watch, computed, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";

defineOptions({
    layout: null,
});

let { email, status, expire_at } = defineProps({
    email: {
        type: String,
        default: "",
    },
    status: {
        type: String,
    },
    expire_at: {
        type: Number,
    },
});

const form = useForm({
    otp: "",
});

let timer = ref(180);
let runningTime = null;

let displayTime = computed(() => {
    let minutes = Math.floor(timer.value / 60);
    let seconds = timer.value % 60;
    return `${minutes} : ${seconds.toString().padStart(2, "0")}`;
});

const startTimer = (startTime = null) => {
    if (startTime != null) {
        timer.value = startTime;
    } else {
        timer.value = 180;
    }
    if (runningTime) clearInterval(runningTime);
    runningTime = setInterval(() => {
        timer.value--;
        if (timer.value <= 0) {
            clearInterval(runningTime);
        }
    }, 1000);
};

onMounted(() => {
    let currentTime = Math.floor(Date.now() / 1000);
    let remainingTime = expire_at - currentTime;
    if (remainingTime > 0) {
        startTimer(remainingTime);
    } else {
        timer.value = 0;
    }
});
onUnmounted(() => {
    clearInterval(runningTime);
});

let resendCode = () => {
    router.post(
        route("password.email"),
        { email },
        {
            onSuccess: () => startTimer(),
        }
    );
};

const otpInputs = ref([]);
const otpValues = ref(["", "", "", "", "", ""]);

onMounted(() => {
    // Focus first input on mount
    if (otpInputs.value[0]) {
        otpInputs.value[0].focus();
    }
});

const handleInput = (index, event) => {
    const value = event.target.value.replace(/[^0-9]/g, "");

    if (value.length > 1) {
        // Handle paste: fill all inputs
        const pastedDigits = value.slice(0, 6).split("");
        pastedDigits.forEach((digit, i) => {
            if (i < 6) {
                otpValues.value[i] = digit;
            }
        });

        // Focus the last filled input or submit if all filled
        const lastFilledIndex = Math.min(pastedDigits.length - 1, 5);
        if (otpInputs.value[lastFilledIndex]) {
            otpInputs.value[lastFilledIndex].focus();
        }

        updateOtpValue();
        return;
    }

    otpValues.value[index] = value;

    // Auto-advance to next input
    if (value && index < 5 && otpInputs.value[index + 1]) {
        otpInputs.value[index + 1].focus();
    }

    updateOtpValue();
};

const handleKeyDown = (index, event) => {
    // Handle backspace
    if (event.key === "Backspace" && !otpValues.value[index] && index > 0) {
        otpInputs.value[index - 1].focus();
    }

    // Handle arrow keys
    if (event.key === "ArrowLeft" && index > 0) {
        otpInputs.value[index - 1].focus();
    }
    if (event.key === "ArrowRight" && index < 5) {
        otpInputs.value[index + 1].focus();
    }
};

const handlePaste = (event) => {
    event.preventDefault();
    const pastedData = event.clipboardData
        .getData("text")
        .replace(/[^0-9]/g, "")
        .slice(0, 6);

    pastedData.split("").forEach((digit, i) => {
        if (i < 6) {
            otpValues.value[i] = digit;
        }
    });

    updateOtpValue();

    // Focus the last filled input
    const lastFilledIndex = Math.min(pastedData.length - 1, 5);
    if (otpInputs.value[lastFilledIndex]) {
        otpInputs.value[lastFilledIndex].focus();
    }
};

const updateOtpValue = () => {
    form.otp = otpValues.value.join("");
};

const submit = () => {
    if (form.otp.length === 6) {
        form.post(route("otp.verify"));
    }
};

// Watch for form errors and reset OTP if needed
watch(
    () => form.errors.otp,
    () => {
        if (form.errors.otp) {
            // Optionally clear OTP on error
            // otpValues.value = ['', '', '', '', '', ''];
            // form.otp = '';
        }
    }
);
</script>

<template>
    <Head title="Verify OTP" />

    <div class="mb-4 text-sm text-gray-600">
        <div class="mb-2">
            <p class="mb-2">
                We've sent a 6-digit verification code to
                <span class="font-medium">{{ email }}</span>
            </p>
            <div class="flex items-center gap-2">
                <span class="text-gray-500">Email wrong?</span>
                <button
                    type="button"
                    @click="router.post(route('password.changeEmail'))"
                    class="text-sm font-medium text-indigo-600 underline hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded"
                >
                    Change Email
                </button>
            </div>
        </div>
        <p>Please enter the 6-digit verification code sent to your email.</p>
    </div>

    <div v-if="email" class="mb-4 text-sm font-medium text-green-600">
        {{ status }} ({{ displayTime }})
    </div>

    <form @submit.prevent="submit">
        <div>
            <InputLabel for="otp" value="Verification Code" />

            <div
                class="mt-2 flex gap-2 justify-center"
                @paste.prevent="handlePaste"
            >
                <input
                    v-for="(value, index) in otpValues"
                    :key="index"
                    :ref="(el) => (otpInputs[index] = el)"
                    type="text"
                    inputmode="numeric"
                    maxlength="1"
                    :value="value"
                    @input="handleInput(index, $event)"
                    @keydown="handleKeyDown(index, $event)"
                    class="h-14 w-14 rounded-lg border border-gray-300 text-center text-2xl font-semibold focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none transition-colors"
                    :class="{
                        'border-red-500 focus:border-red-500 focus:ring-red-500':
                            form.errors.otp,
                    }"
                />
            </div>

            <InputError class="mt-2" :message="form.errors.otp" />
        </div>

        <div class="mt-6 flex items-center justify-between">
            <button
                type="button"
                @click="resendCode"
                class="text-sm text-gray-600 underline focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded"
                :class="[
                    timer > 0
                        ? 'cursor-not-allowed'
                        : 'cursor-pointer hover:text-gray-900',
                ]"
                :disabled="timer > 0"
            >
                Resend Code
            </button>

            <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing || form.otp.length !== 6"
            >
                Verify
            </PrimaryButton>
        </div>
    </form>
</template>
