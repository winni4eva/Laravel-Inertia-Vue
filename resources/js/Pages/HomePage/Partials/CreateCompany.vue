<template>
  <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company Create
            </h2>
        </template>

        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <div class="divide-y divide-gray-200 py-4 px-4">

                  <form method="POST" class="my-5" @submit.prevent="createCompany">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 py-4 px-4 w-6/12">
                      <div class="flex flex-col">
                        <jet-label>
                          <i class="fa fa-building"/>
                          Company Name
                        </jet-label>
                        <jet-input 
                          v-model="form.name" 
                          class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                          placeholder="Company"/>
                          <jet-input-error v-if="hasErrors[0] === 'name'" :message="errors[hasErrors[0]]" class="mt-2" />
                      </div>

                      <div class="flex flex-col">
                        <jet-label>
                          <i class="fa fa-internet-explorer"/>
                          Website
                        </jet-label>
                        <jet-input 
                          v-model="form.url" 
                          class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                          placeholder="Website"/>
                        <jet-input-error v-if="hasErrors[0] === 'url'" :message="errors[hasErrors[0]]" class="mt-2" />
                      </div>
                      
                      <div class="flex flex-col">
                        <jet-label>
                          <i class="fa fa-at"/>
                          Email
                        </jet-label>
                        <jet-input 
                          v-model="form.email" 
                          class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                          placeholder="Email"/>
                        <jet-input-error v-if="hasErrors[0] === 'email'" :message="errors[hasErrors[0]]" class="mt-2" />
                      </div>

                      <div class="flex flex-col">
                        <jet-label>
                          <i class="fa fa-phone"/>
                          Phone
                        </jet-label>
                        <jet-input 
                          v-model="form.phone" 
                          class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"
                          placeholder="Phone"/>
                        <jet-input-error v-if="hasErrors[0] === 'phone'" :message="errors[hasErrors[0]]" class="mt-2" />
                      </div>

                    </div>
                    <div class="pt-4 p flex items-center space-x-4 w-6/12">
                        <button class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none">Create</button>
                    </div>
                  </form>
                </div>

              </div>
          </div>
        </div>
    </app-layout>
</template>

<script>
  import JetLabel from "@/Jetstream/Label";
  import JetInput from "@/Jetstream/Input";
  import JetInputError from '@/Jetstream/InputError'
  import AppLayout from "../../../Layouts/AppLayout";
  export default {
    name: "CreateCompany",
    components: {JetInput, JetLabel, JetInputError, AppLayout},
    props: {
      user: Object,
      errors: Object
    },
    data() {
      return {
        form: {
            name: '',
            url: '',
            email: '',
            phone: ''
        },
        showErrorMessage: false,
      }
    },
    methods: {
      createCompany() {
        this.showErrorMessage = false;
        const { id: userId } = this.user;

        this.$inertia.post(`manager/${userId}`, this.form)
          .then(() => {
            this.showErrorMessage = true;
          })
          .catch(error => {
            console.error(error)
          })
      }
    },
    computed: {
        hasErrors() {
          return Object.keys(this.errors);
        },
    },
  }
</script>

<style scoped>

</style>
