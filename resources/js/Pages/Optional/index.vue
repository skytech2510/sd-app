<script setup>
import Breadcrumb from "@/Components/Breadcrumb.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import Pagination from "@/Components/Pagination.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import Link from "@/Components/Link.vue";
import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

let term = ref("");
const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 1, name: "Optional", url: "/optionals" },
});

watch(term, (value) => {
  router.get("/solucao", { term: value });
});

const props = defineProps({
  optionals: Object,
});
</script>

<template>
  <Head title="Optional" />
  <AuthenticatedLayout>
    <div class="mx-auto max-w-7xl sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" class="pt-4 pb-6" />
      <div class="bg-white">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
          <div class="grid grid-cols-7 gap-3 px-4 py-6 text-slate-600">
            <div class="">
              <ButtonLink variant="primary" class="block" value="/opcionals/criar"
                >NOVO OPCIONAL
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
            class="w-full text-sm font-light text-left text-gray-500 dark:text-gray-400"
          >
            <thead
              class="uppercase text-slate-600 bg-slate-300 dark:bg-gray-700 dark:text-gray-400"
            >
              <tr>
                <th scope="col" class="px-6 py-2.5 w-2">#</th>
                <th scope="col" class="px-6 font-light">Nome</th>
                <th scope="col" class="px-6 font-light">FABRICANTE</th>
                <th scope="col" class="px-6 font-light">PRECO</th>
                <th scope="col" class="w-64 px-6"></th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="optional in optionals"
                :key="optional.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-slate-600"
              >
                <td scope="row" class="px-6 py-4">
                  {{ optional.id }}
                </td>
                <td scope="row" class="w-full px-6">
                  {{ optional.name }}
                </td>
                <td scope="row" class="w-full px-6">
                  {{ optional["manufacturer"]["name"] }}
                </td>
                <td scope="row" class="w-full px-6">$ {{ optional.price }}</td>

                <td>
                  <ButtonLink
                    variant="basic"
                    :href="`/optionals/${optional.id}/editar`"
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
                </td>
              </tr>
            </tbody>
          </table>
          <div class="justify-end w-full py-5 bg-white">
            <!--<Pagination></Pagination>-->
          </div>
        </div>
      </div>
    </div>
    <br /><br />
  </AuthenticatedLayout>
</template>
