<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import Otp from "./Otp.vue";

defineOptions({
    layout: null,
});
defineProps({
    status: {
        type: String,
    },
    email: {
        type: String,
    },
    expire_at: {
        type: Number,
    },
});
const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("password.email"));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
        <div v-if="!email">
            <div class="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        true
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Send OTP
                    </PrimaryButton>
                </div>
            </form>
        </div>
        <div v-else>
            <Otp :email="email" :status="status" :expire_at="expire_at" />
        </div>
    </GuestLayout>
</template>
