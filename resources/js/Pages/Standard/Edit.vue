<script setup>
import { reactive, ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import TextInput from "@/Components/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import InputLabel from "@/Components/InputLabel.vue";
import axios from "axios";
const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 2, name: "Solução", url: "/solucao" },
});
const fittings = [
  { id: 1, name: "AAA" },
  { id: 2, name: "BBB" },
  { id: 3, name: "CCC" },
  { id: 4, name: "DDD" },
];
const props = defineProps({
  standard: Object,
  solutions: Object,
  manufacturers: Object,
  collections: Object,
  optionals: Object,
  triggers: Object,
});

const pageState = reactive({
  collections: props.collections,
  drive: { trigger: { id: null, name: null }, item: null, price: 0 },
  optional: { id: null, name: null },
  supply: { id: null, name: null, quality_per_meter: 0 },
});
const form = useForm({
  name: props.standard.name,
  solution_id: props.standard.solution_id,
  manufacturer_id: props.standard.manufacturer_id,
  collection_ids: props.standard.collection_ids,
  colors: props.standard.colors,
  min_width: props.standard.min_width,
  max_width: props.standard.max_width,
  min_height: props.standard.min_height,
  max_height: props.standard.max_height,
  max_area: props.standard.max_area,
  product_feature: props.standard.product_feature,
  NCM: props.standard.NCM,
  CFOP: props.standard.CFOP,
  drives: props.standard.drives,
  optionals: props.standard.optionals,
  supplies: props.standard.supplies,
});
const setSelectSolution = (event) => {
  getCollections(event.target.value);
};
const getCollections = async () => {
  const res = await axios.get(`getCollections/${form.solution_id}`);
  pageState.collections = res.data;
};
const addDrive = (event) => {
  event.preventDefault();
  pageState.drive.item &&
    pageState.drive.price &&
    pageState.drive.trigger &&
    form.drives.push({ ...pageState.drive });
};
const removeDrive = (event, index) => {
  event.preventDefault();
  form.drives.splice(index, 1);
};
const addOptional = (event) => {
  event.preventDefault();
  pageState.optional.id && form.optionals.push({ ...pageState.optional });
};
const removeOptional = (event, index) => {
  event.preventDefault();
  form.optionals.splice(index, 1);
};
const addSupply = (event) => {
  event.preventDefault();
  pageState.supply.id &&
    pageState.supply.name &&
    form.supplies.push({ ...pageState.supply });
};
const removeSupply = (event, index) => {
  event.preventDefault();
  form.supplies.splice(index, 1);
};
const hardwareColors = [
  { value: "us3", label: "US3 Bright Brass" },
  { value: "us4", label: "US4 Satin Brass" },
  { value: "us10", label: "US10 Satin Bronze" },
  { value: "us10b", label: "US10B Oil Rubbed Bronze" },
  { value: "us15", label: "US15 Satin Nickel" },
  { value: "us26", label: "US26 Bright Chrome" },
  { value: "us26d", label: "US26D Satin Chrome" },
  { value: "us32d", label: "US32D Satin Stainless Steel" },
  { value: "black", label: "Black" },
  { value: "white", label: "White" },
  { value: "gray", label: "Gray" },
];
function storeSolution() {
  //   console.log(form.colors);
  form.post(route("standard.store"));
}
</script>

<template>
  <Head title="Canal" />
  {{ form.errors }}
  <AuthenticatedLayout>
    <div class="pt-4 mx-auto max-w-7xl sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="storeSolution">
            <div class="pb-12 border-b border-slate-900/10">
              <div class="flex flex-col gap-5">
                <div>
                  <h1 class="uppercase">informação do modelo</h1>
                  <hr />
                  <div class="flex flex-col gap-3 mt-5">
                    <div class="flex flex-row gap-3">
                      <div class="flex-[2]">
                        <TextInput
                          textLabel="Nome"
                          title="name"
                          name="name"
                          type="text"
                          v-model="form.name"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <InputLabel>Solução</InputLabel>
                        <select
                          @change="setSelectSolution"
                          name=""
                          id=""
                          v-model="form.solution_id"
                          class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                        >
                          <option value="-1">Selecione</option>
                          <option
                            v-for="(item, index) in solutions"
                            :key="index"
                            :value="item.id"
                          >
                            {{ item.name }}
                          </option>
                        </select>
                      </div>
                      <div class="flex-1">
                        <InputLabel>Fabricante</InputLabel>
                        <select
                          name=""
                          id=""
                          v-model="form.manufacturer_id"
                          class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                        >
                          <option value="null">Selecione</option>
                          <option
                            v-for="(item, index) in manufacturers"
                            :key="index"
                            :value="item.id"
                          >
                            {{ item.name }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="flex flex-row gap-3">
                      <div class="flex-1">
                        <InputLabel>Coleções</InputLabel>
                        <select
                          name=""
                          id=""
                          multiple
                          v-model="form.collection_ids"
                          required
                          class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                        >
                          <option
                            v-for="(item, index) in pageState.collections"
                            :key="index"
                            :value="item.id"
                          >
                            {{ item.name }}
                          </option>
                        </select>
                      </div>
                      <div class="flex-1">
                        <InputLabel>Cor do Acessórios</InputLabel>
                        <select
                          name=""
                          id=""
                          multiple
                          required
                          v-model="form.colors"
                          class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                        >
                          <option
                            v-for="(item, index) in hardwareColors"
                            :key="index"
                            :value="item.value"
                          >
                            {{ item.label }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <h1 class="uppercase">LIMITES E DIMENSÕES</h1>
                  <hr />
                  <div class="flex flex-col gap-3 mt-5">
                    <div class="flex flex-row gap-3">
                      <div class="flex-1">
                        <TextInput
                          textLabel="Largura Mínima:"
                          title="min_width"
                          name="min_width"
                          type="number"
                          v-model="form.min_width"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Largura Máxima:"
                          title="max_width"
                          name="max_with"
                          type="number"
                          v-model="form.max_width"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Altura Mínima:"
                          title="min_height"
                          name="min_height"
                          type="number"
                          v-model="form.min_height"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="Altura Máxima:"
                          title="max_height"
                          name="max_height"
                          type="number"
                          v-model="form.max_height"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="M² Máximo:"
                          title="max_area"
                          name="max_area"
                          type="number"
                          v-model="form.max_area"
                        ></TextInput>
                      </div>
                      <div class="flex-1"></div>
                    </div>
                  </div>
                </div>
                <div>
                  <h1 class="uppercase">CARACTERÍSTICAS DO PRODUTO</h1>
                  <hr />
                  <div class="flex flex-col gap-3 mt-5">
                    <div class="flex flex-row gap-3">
                      <div class="flex-1">
                        <InputLabel>Informações:</InputLabel>
                        <textarea
                          v-model="form.product_feature"
                          name=""
                          id=""
                          class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div v-if="form.solution_id !== -1">
                  <div v-if="form.solution_id === 1">
                    <h1 class="uppercase">AVIAMENTOS</h1>
                    <hr />
                    <div class="flex flex-col gap-3 mt-5">
                      <div class="flex flex-row gap-3">
                        <div class="flex-[2]">
                          <InputLabel>Aviamento:</InputLabel>
                          <select
                            v-model="pageState.supply"
                            name=""
                            id=""
                            class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                          >
                            <option value="">Selecione</option>
                            <option
                              v-for="(item, index) in fittings"
                              :key="index"
                              :value="item"
                            >
                              {{ item.name }}
                            </option>
                          </select>
                        </div>
                        <div class="flex-1">
                          <TextInput
                            textLabel="Qtde P/ Metro:"
                            title="Qtde P/ Metro"
                            name="Qtde P/ Metro"
                            type="number"
                            v-model="pageState.supply.quality_per_meter"
                          ></TextInput>
                        </div>
                        <div class="flex-[3] flex flex-col justify-end">
                          <Button
                            style="width: fit-content; text-transform: uppercase"
                            variant="danger"
                            @click="addSupply"
                            >adicionar</Button
                          >
                        </div>
                      </div>
                      <div>
                        <table
                          class="w-full text-sm font-light text-left text-gray-500 dark:text-gray-400"
                        >
                          <thead
                            class="uppercase text-slate-600 bg-slate-300 dark:bg-gray-700 dark:text-gray-400"
                          >
                            <tr>
                              <th scope="col" class="px-6 py-2.5 w-2">Nome</th>
                              <th scope="col" class="px-6 font-light">Qtde</th>
                              <th scope="col" class="w-64 px-6"></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(item, index) in form.supplies" :key="index">
                              <td>{{ item.name }}</td>
                              <td>{{ item.quality_per_meter }}</td>
                              <td>
                                <Button
                                  @click="
                                    (event) => {
                                      removeSupply(event, index);
                                    }
                                  "
                                  ><svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    height="24px"
                                    viewBox="0 -960 960 960"
                                    width="24px"
                                    fill="#5f6368"
                                  >
                                    <path
                                      d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"
                                    /></svg
                                ></Button>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div v-if="form.solution_id === 2" class="flex flex-col gap-5">
                    <div>
                      <h1 class="uppercase">ACIONAMENTO</h1>
                      <hr />
                      <div class="flex flex-col gap-3 mt-5">
                        <div class="flex flex-row gap-3">
                          <div class="flex-[2]">
                            <InputLabel>Acionamento:</InputLabel>
                            <select
                              name=""
                              id=""
                              v-model="pageState.drive.trigger"
                              class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                            >
                              <option value="">Selecione</option>
                              <option
                                v-for="(item, index) in triggers"
                                :key="index"
                                :value="{ id: item.id, name: item.name }"
                              >
                                {{ item.name }}
                              </option>
                            </select>
                          </div>
                          <div class="flex-1">
                            <InputLabel>Unid. Cálculo:</InputLabel>
                            <select
                              name=""
                              id=""
                              v-model="pageState.drive.item"
                              class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                            >
                              <option value="">Selecione</option>
                              <option value="addtion ">Acréscimo</option>
                              <option value="width ">Largura</option>
                              <option value="part ">Peça</option>
                            </select>
                          </div>
                          <div class="flex-1">
                            <TextInput
                              textLabel="Preço:"
                              title="price"
                              name="price"
                              type="number"
                              v-model="pageState.drive.price"
                            ></TextInput>
                          </div>
                          <div class="flex-[3] flex flex-col justify-end">
                            <Button
                              style="width: fit-content; text-transform: uppercase"
                              variant="danger"
                              @click="addDrive"
                              >adicionar</Button
                            >
                          </div>
                        </div>
                        <div>
                          <table
                            class="w-full text-sm font-light text-left text-gray-500 dark:text-gray-400"
                          >
                            <thead
                              class="uppercase text-slate-600 bg-slate-300 dark:bg-gray-700 dark:text-gray-400"
                            >
                              <tr>
                                <th scope="col" class="px-6 py-2.5 w-2">Nome</th>
                                <th scope="col" class="px-6 font-light">Unid.</th>
                                <th scope="col" class="px-6 font-light">Preço</th>
                                <th scope="col" class="w-64 px-6"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(item, index) in form.drives" :key="index">
                                <td>{{ item.trigger.name }}</td>
                                <td>{{ item.item }}</td>
                                <td>$ {{ item.price }}</td>
                                <td>
                                  <Button
                                    @click="
                                      (event) => {
                                        removeDrive(event, index);
                                      }
                                    "
                                    ><svg
                                      xmlns="http://www.w3.org/2000/svg"
                                      height="24px"
                                      viewBox="0 -960 960 960"
                                      width="24px"
                                      fill="#5f6368"
                                    >
                                      <path
                                        d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"
                                      /></svg
                                  ></Button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div>
                      <h1 class="uppercase">OPCIONAIS</h1>
                      <hr />
                      <div class="flex flex-col gap-3 mt-5">
                        <div class="flex flex-row gap-3">
                          <div class="flex-[4]">
                            <InputLabel>Opcionais:</InputLabel>
                            <select
                              name=""
                              id=""
                              v-model="pageState.optional"
                              class="w-full text-sm rounded-md shadow-sm border-slate-300 focus:border-sky-500 focus:ring-sky-500"
                            >
                              <option value="null">Selecione</option>
                              <option
                                v-for="(item, index) in optionals"
                                :key="index"
                                :value="{ id: item.id, name: item.name }"
                              >
                                {{ item.name }}
                              </option>
                            </select>
                          </div>
                          <div class="flex-[3] flex flex-col justify-end">
                            <Button
                              style="width: fit-content; text-transform: uppercase"
                              variant="danger"
                              @click="addOptional"
                              >adicionar</Button
                            >
                          </div>
                        </div>
                        <div>
                          <table
                            class="w-full text-sm font-light text-left text-gray-500 dark:text-gray-400"
                          >
                            <thead
                              class="uppercase text-slate-600 bg-slate-300 dark:bg-gray-700 dark:text-gray-400"
                            >
                              <tr>
                                <th scope="col" class="px-6 py-2.5 w-2">Nome</th>
                                <th scope="col" class="w-64 px-6"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="(item, index) in form.optionals" :key="index">
                                <td>{{ item.name }}</td>
                                <td>
                                  <Button
                                    @click="
                                      (event) => {
                                        removeOptional(event, index);
                                      }
                                    "
                                    ><svg
                                      xmlns="http://www.w3.org/2000/svg"
                                      height="24px"
                                      viewBox="0 -960 960 960"
                                      width="24px"
                                      fill="#5f6368"
                                    >
                                      <path
                                        d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"
                                      /></svg
                                  ></Button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <h1 class="uppercase">TRIBUTAÇÃO</h1>
                  <hr />
                  <div class="flex flex-col gap-3 mt-5">
                    <div class="flex flex-row gap-3">
                      <div class="flex-1">
                        <TextInput
                          textLabel="NCM:"
                          title="NCM"
                          name="NCM"
                          type="text"
                          v-model="form.NCM"
                        ></TextInput>
                      </div>
                      <div class="flex-1">
                        <TextInput
                          textLabel="CFOP:"
                          title="CFOP"
                          name="CFOP"
                          type="text"
                          v-model="form.CFOP"
                        ></TextInput>
                      </div>
                      <div class="flex-[2]"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-1 pt-6 gap-x-6 gap-y-8 sm:grid-cols-6">
              <div class="space-x-2 sm:col-span-4">
                <Button
                  variant="primary"
                  type="submit"
                  class=""
                  :disabled="form.processing"
                  :class="{ 'opacity-25': form.processing }"
                >
                  SALVAR
                </Button>
                <ButtonLink variant="default" class="" value="/canal">VOLTAR </ButtonLink>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
