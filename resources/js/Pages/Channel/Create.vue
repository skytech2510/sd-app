<script setup>
import { ref } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import Button from "@/Components/Button.vue";
import ButtonLink from "@/Components/ButtonLink.vue";
import TextInput from "@/Components/TextInput.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const breadcrumb = ref({
  page: { id: 1, name: "Configurações", url: "/configuracao" },
  link: { id: 2, name: "Canal", url: "/canal" },
});
const form = useForm({
  name: null,
});

function storeChannel() {
  form.post("/canal");
}
</script>

<template>
  <Head title="Canal" />

  <AuthenticatedLayout>
    <div class="pt-4 mx-auto max-w-7xl sm:px-4 lg:px-10">
      <breadcrumb :value="breadcrumb" type="back" class="pb-5" />
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <form @submit.prevent="storeChannel">
            <div class="pb-12 border-b border-slate-900/10">
              <h2 class="text-base font-semibold leading-7 text-sky-900">
                Informações do Canal
              </h2>
              <div class="grid grid-cols-1 mt-3">
                <TextInput
                  textLabel="Nome"
                  type="text"
                  v-model="form.name"
                  name="name"
                  class="w-full"
                  placeholder=""
                />
                <div v-if="form.errors.name" class="mt-2 text-sm text-red-500">
                  {{ form.errors.name }}
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
