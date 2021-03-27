<template>
  <tr>
      <td class="px-6 py-4 whitespace-nowrap">
          <div class="flex items-center">
              <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">
                      {{ name }}
                  </div>
                      <a :href="url" class="text-sm text-gray-900" target="_blank">Web Site <i class="fa fa-link"></i></a><br>
              </div>
          </div>
      </td>
      <td class="px-6 py-4 whitespace-nowrap">

          <div class="text-sm text-gray-900">
              {{ phone }}
          </div>

          <a :href="'mailto:' + email" class="text-sm text-gray-900">{{ email }}</a>
      </td>
      <td class="px-6 py-4 whitespace-nowrap">
          <span class="px-2 inline-flex text-xs leading-5 font-semibold">
              <rating
                  :rating="company.rating"
                  :user-rating="userRating"
                  :max-rating="maxRating"
                  @storeRating="storeRating"
                  :can-rate="canRate"
              />
          </span>
      </td>
      <td 
        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" 
        v-if="user">
          <i
              v-if="canEdit"
              class="fa fa-edit pr-2 cursor-pointer"
              @click="showModal = true"
          />
          <i
              v-if="canDelete"
              @click="deleteCompany"
              class="fa fa-trash text-red-500 cursor-pointer"
          />
      </td>
      <dialog-modal
          :show="showModal"
      >
          <template #title>
              Edit Company
          </template>

          <template #content>

              <update-company
                  ref="update"
                  :company="company"
                  :user="user"
                  @refreshCompanies="refreshCompanies"
                  @closeModal="showModal = false"
              />

          </template>

          <template #footer>
              <secondary-button
                  @click="showModal = false"
                  class="pr-3"
              >
                  Cancel
              </secondary-button>
              <jet-button
                  @click="updateCompany"
              >
                  Update
              </jet-button>
          </template>
      </dialog-modal>
  </tr>
</template>

<script>
    import Rating from "@/Components/Rating";
    import Modal from "@/Jetstream/Modal";
    import DialogModal from "@/Jetstream/DialogModal";
    import UpdateCompany from "@/Pages/HomePage/Partials/UpdateCompany";
    import JetButton from "@/Jetstream/Button";
    import SecondaryButton from "@/Jetstream/SecondaryButton";
    export default {
        name: "Company",
        components: {SecondaryButton, JetButton, UpdateCompany, DialogModal, Modal, Rating},
        props: {
            company: Object,
            maxRating: Number,
            showModal: false,
            user: Object,
        },
        data() {
            return {
                userRating: _.get(this, 'company.user_rating')
            }
        },
        computed: {
            canRate() {
                return this.$page.props.user !== null ;
            },
            name() {
                return _.get(this.company, 'name')
            },
            url() {
                return _.get(this.company, 'url')
            },
            email() {
                return _.get(this.company, 'email')
            },
            phone() {
                return _.get(this.company, 'phone')
            },
            editPath() {
                return _.get(this.company, '@id') + '/edit'
            },
            canEdit() {
                return _.get(this.company, '@canEdit')
            },
            canDelete() {
                return _.get(this.company, '@canDelete')
            },
        },
        methods: {
            storeRating(rating) {
              console.log('My Rating ', rating);
              this.userRating = rating
              axios.post(this.company['@id'] + '/rate',{rating})
              .then(response => {})
              .catch(error => {
                  console.error(error)
              })
            },
            deleteCompany() {
                if(confirm('Are you sure you want to Delete ' + this.company.name + '?')) {
                    axios.delete(_.get(this.company, '@id'))
                    .then(() => {
                        this.$emit('refreshCompanies');
                    })
                    .catch(error => {
                        console.log(error)
                    })
                }
            },
            updateCompany() {
                this.$refs.update.update();
            },
            refreshCompanies() {
              this.$emit('refreshCompanies');
            },
        }
    }
</script>

<style scoped>

</style>
