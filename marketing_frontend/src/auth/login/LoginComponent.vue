<template>
    <div class="tw:w-[100%] tw:h-[100%]">
        <div class="tw:h-[25%] tw:w-full  tw:bg-gray-300 tw:rounded-bl-[103px] tw:p-15">
            <!-- <div>
                <v-btn icon="mdi-arrow-left"  variant="plain"></v-btn>
            </div> -->
            <div class="tw:mt-5">
                <div class="tw:text-2xl tw:font-extrabold">
                    Welcome Back
                </div>
                <div class="tw:mt-2">
                    It's good to see you again.
                </div>
            </div>
        </div>
        <div class="tw:p-20 tw:h-[75%]">
             <v-sheet class="mx-auto" width="300">
                <v-form @submit.prevent lazy-validation>
                <v-text-field
                    v-model="email"
                    :rules="emailRules"
                    type="email"
                    label="Email"
                    required
                    outlined
                ></v-text-field>
                <v-text-field
                    v-model="password"
                    type="password"
                    label="Password"
                    :rules="passwordRules"
                    append-inner-icon="mdi-eye"
                >
                </v-text-field>
                <!-- <div class="text-center">
                    or continue with
                </div>
                <div class="tw:grid tw:grid-cols-2 tw:grid-flow-col tw:mt-5 tw:gap-3">
                    <div class="tw:col-span-1 tw:text-center">
                        <v-btn prepend-icon="mdi-facebook"  size="small" rounded="xl"  class="tw:w-xl">Facebook</v-btn>
                    </div>
                    <div class="tw:col-span-1 tw:text-center">
                        <v-btn  size="small" prepend-icon="mdi-google"   rounded="xl"  class="tw:w-xl">Google</v-btn>
                    </div>
                </div> -->
                <div class="tw:mt-3">
                    <v-btn style="text-transform: none;" size="x-large" rounded="xl" type="submit" block><span class="tw:font-bold">Submit</span></v-btn>
                </div>
                </v-form>
            </v-sheet>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';


const email = ref(null);
const loading = ref(false);

const emailRules = ref([
        v => !!v || 'Email is required',
        v => /.+@.+\..+/.test(v) || 'Email must be valid',
        v => v.length <= 100 || 'Email must be less than 100 characters'
]);

const passwordRules = ref([
         v => !!v || 'Password is required',
]);
</script>