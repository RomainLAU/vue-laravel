<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    apiKey: String | Object,
});

const isPasswordVisible = ref(false);
const apiKeyRef = ref(
    typeof props.apiKey === "string" ? props.apiKey : props.apiKey.key
);

const form = useForm({
    name: "",
    apiKey: apiKeyRef.value,
});

const submit = () => {
    if (typeof props.apiKey === "string") {
        form.post(route("api-keys.store"));
    }
};
</script>

<template>
    <Head title="API" />
    <HeaderLayout>
        <template #title> API </template>
        <template #action></template>
        <template #content>
            <form @submit.prevent="submit" class="flex flex-col gap-y-4">
                <div class="flex flex-col gap-y-2">
                    <label for="name">Give a name to your API key: </label>
                    <input
                        v-model="form.name"
                        type="string"
                        placeholder="API key name"
                        class="px-2 rounded-lg border border-black w-1/4"
                        id="name"
                    />
                    <p
                        v-if="form.errors.name"
                        class="text-red-500 text-xs italic"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>
                <div>
                    <label for="apiKey">Get your API key: </label>
                    <div
                        class="flex w-[36rem] rounded-lg border border-black items-center px-2"
                    >
                        <input
                            v-model="form.apiKey"
                            :type="`${isPasswordVisible ? 'text' : 'password'}`"
                            placeholder="Shouldn't be empty...'"
                            class="rounded-lg w-full border-none"
                            id="apiKey"
                        />
                        <svg
                            v-if="isPasswordVisible"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth="{1.5}"
                            stroke="currentColor"
                            class="w-8 h-8"
                            @click="isPasswordVisible = false"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                            />
                        </svg>
                        <svg
                            v-if="!isPasswordVisible"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth="{1.5}"
                            stroke="currentColor"
                            class="w-8 h-8"
                            @click="isPasswordVisible = true"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                            />
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>
                    </div>
                    <p
                        v-if="form.errors.apiKey"
                        class="text-red-500 text-xs italic"
                    >
                        {{ form.errors.apiKey }}
                    </p>
                </div>
                <input
                    v-if="typeof apiKey === 'string'"
                    type="submit"
                    value="Save the API key"
                    class="bg-blue-500 hover:bg-blue-700 rounded-lg px-4 py-2 text-white font-bold hover:cursor-pointer w-fit"
                />
                <Link
                    v-else
                    :href="route('api-keys.destroy', { api_key: apiKey })"
                    method="delete"
                    as="button"
                    class="bg-red-500 hover:bg-red-700 rounded-lg px-4 py-2 text-white font-bold hover:cursor-pointer w-fit"
                    >Delete the API key</Link
                >
            </form>
        </template>
    </HeaderLayout>
</template>
