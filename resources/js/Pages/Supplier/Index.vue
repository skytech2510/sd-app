<script setup>
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import Pagination from "@/Components/Pagination.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import Link from "@/Components/Link.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

let term = ref("");
const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 1, name: "Fornecedor", url: "/fornecedor" },
});

watch(term, (value) => {
  router.get("/fornecedor", { term: value });
});

const props = defineProps({
  suppliers: Object,
});

const form = useForm({});

function destroy(supplier) {
  if (confirm("Confirma a exclusão deste fornecedor?")) {
    form.delete(route("supplier.destroy", supplier));
  }
}
</script>

<template>
  <Head title="Fornecedores" />

  <AuthenticatedLayout>
    <div class="max-w-7xl mx-auto sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" class="pt-4 pb-6" />
      <div class="bg-white">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <div class="grid grid-cols-7 gap-3 px-4 py-6 text-slate-600">
            <div class="">
              <ButtonLink variant="primary" class="block" value="/fornecedor/criar"
                >NOVO
              </ButtonLink>
            </div>
            <div class="col-span-3">
              <TextInput
                type="text"
                name="search"
                v-model="term"
                class="w-full"
                placeholder="Pesquisar"
              />
            </div>
          </div>
          <table
            class="w-full text-sm text-left font-light text-gray-500 dark:text-gray-400"
          >
            <thead
              class="text-slate-600 uppercase bg-slate-300 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-6 py-2.5 w-2">#</th>
                <th scope="col" class="px-6 font-light">Nome</th>
                <th scope="col" class="px-6 font-light">Documento</th>
                <th scope="col" class="px-6 font-light">Cidade</th>
                <th scope="col" class="px-6 font-light">Celular</th>
                <th scope="col" class="px-6 font-light">Representante</th>
                <th scope="col" class="px-6 w-64"></th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="supplier in suppliers"
                :key="supplier.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-slate-600"
              >
                <td scope="row" class="px-6 py-4">
                  {{ supplier.id }}
                </td>
                <td scope="row" class="px-6 col-span-3">
                  {{ supplier.name }}
                </td>
                <td scope="row" class="px-6">
                  {{ supplier.document }}
                </td>
                <td scope="row" class="px-6">
                  {{ supplier.city.nome }} / {{ supplier.state.nome }}
                </td>
                <td scope="row" class="px-6">
                  {{ supplier.phone }}
                </td>
                <td scope="row" class="px-6">
                  {{ supplier.accountable_name }}
                </td>

                <td class="flex justify-end px-6 py-4">
                  <ButtonLink
                    variant="basic"
                    :href="`/fornecedor/${supplier.id}/editar`"
                    class=""
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                      />
                    </svg>
                  </ButtonLink>
                  <Button
                    variant="basic"
                    @click="destroy(supplier)"
                    class="text-slate-600"
                    title="Excluir"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="w-6 h-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                      />
                    </svg>
                  </Button>
                </td>
              </tr>
            </tbody>
          </table>
          <div class="w-full bg-white justify-end py-5">
            <!--<Pagination></Pagination>-->
          </div>
        </div>
      </div>
    </div>
    <br /><br />
  </AuthenticatedLayout>
</template>
