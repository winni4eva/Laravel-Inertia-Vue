<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Company List {{searchProperty}}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg float-left">
                    <select v-model="searchProperty">
                        <option>-- search type --</option>
                        <option value="name">Company Name</option>
                        <option value="rating_min">Minimum Rating</option>
                        <option value="rating_max">Maximum Rating</option>
                    </select>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg float-left">
                    <input type="text" placeholder="search company" @input="debounceSearch"/>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <company-list
                        :companies="companies"
                        :max-rating="maxRating"
                        :user="user"
                        @load="loadCompanies"
                        @refreshCompanies="refreshCompanies"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "../../Layouts/AppLayout";
    import CompanyList from "@/Pages/HomePage/Partials/CompanyList";
    import jetInput from "@/Jetstream/Input";
    import jetLabel from "@/Jetstream/Label";
    export default {
        name: "HomePage",
        components: {jetLabel, jetInput, CompanyList, AppLayout},
        props: {
            maxRating: Number,
            user: Object,
        },
        data() {
          return {
              companies: null,
              dataUrl: route('companies.index'),
              searchProperty: 'name',
              debounce: null,
              searchTerm: null,
          }
        },
        mounted() {
            this.refreshCompanies();
        },
        methods: {
          loadCompanies(url) {
            url = `${url}?${this.searchProperty}=${this.searchTerm || ''}`;
            axios.get(url)
                .then((response) => {
                    this.companies = response.data;
                }).catch(error => {
                console.log(error);
            });
          },
          refreshCompanies() {
            this.loadCompanies(this.dataUrl);
          },
          debounceSearch(event) {
            clearTimeout(this.debounce);
            this.debounce = setTimeout(() => {
              this.searchTerm = event.target.value;
              this.refreshCompanies();
            }, 700);
          }
        }
    }

</script>

<style scoped>

</style>
