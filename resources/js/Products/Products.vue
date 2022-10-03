<template>
  <div class="w-full">
    <div class="overflow-x-auto relative">
    <div class="flex justify-between">
      <div class="mb-8 flex space-x-4 align-center">
        <div class="w-64">
          <input
            v-model="search"
            type="text"
            id="base-input"
            placeholder="search for product name"
            class="
              bg-gray-50
              border border-gray-300
              text-gray-900 text-sm
              rounded-lg
              focus:ring-blue-500 focus:border-blue-500
              block
              w-full
              p-2.5
              dark:bg-gray-700
              dark:border-gray-600
              dark:placeholder-gray-400
              dark:text-white
              dark:focus:ring-blue-500
              dark:focus:border-blue-500
            "
          />
        </div>
        <div class="flex items-center">
            <label for="default-toggle" class="inline-flex relative items-center cursor-pointer">
                <input v-model="with_stock" type="checkbox" value="" id="default-toggle" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">With Stock</span>
                </label>
          <!-- <input
            v-model="with_stock"
            id="disabled-checkbox"
            type="checkbox"
            value=""
            class="
              w-4
              h-4
              text-blue-600
              bg-gray-100
              rounded
              border-gray-300
              focus:ring-blue-500
              dark:focus:ring-blue-600 dark:ring-offset-gray-800
              focus:ring-2
              dark:bg-gray-700 dark:border-gray-600
            "
          />
          <label
            for="disabled-checkbox"
            class="ml-2 text-sm font-medium text-gray-400 dark:text-gray-500"
            >With Stocks ?</label
          > -->
        </div>
        
      </div>
      <div>
            <a-button type="primary" @click="openModal">Add Product</a-button>
        </div>
    </div>
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead
          class="
            text-xs text-gray-700
            uppercase
            bg-gray-50
            dark:bg-gray-700 dark:text-gray-400
          "
        >
          <tr>
            <th scope="col" class="py-3 px-6">Name</th>
            <th scope="col" class="py-3 px-6">Description</th>
            <th scope="col" class="py-3 px-6">Price</th>
            <th scope="col" class="py-3 px-6">Quantity</th>
            <th scope="col" class="py-3 px-6">Category</th>
            <th scope="col" class="py-3 px-6">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product in products"
            :key="product.id"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
          >
            <th
              scope="row"
              class="
                py-4
                px-6
                font-medium
                text-gray-900
                whitespace-nowrap
                dark:text-white
              "
            >
              {{ product.name }}
            </th>
            <td class="py-4 px-6">
              {{ product.description }}
            </td>
            <td class="py-4 px-6">
              {{ product.price }}
            </td>
            <td class="py-4 px-6">
              {{ product.quantity }}
            </td>
            <td class="py-4 px-6">
              {{ product.category.name }}
            </td>
            <td class="py-4 px-6"> <a-button type="primary" ghost @click="showUpdateModal(product)">Edit</a-button> <a-button @click="deleteProduct(product.id)" type="primary" danger ghost>Delete</a-button></td>
          </tr>
        </tbody>
      </table>
    </div>
    <Modal v-model:visible="visible" title="Product"  @ok="handleOk">
        <template #footer>
        <a-button key="back" @click="handleCancel">Return</a-button>
        <a-button key="submit" type="primary" :loading="loading" @click="handleOk">Submit</a-button>
      </template>
        <form class="px-8 pt-6 pb-8 mb-4">
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Product Name
      </label>
      <input v-model="form.name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Product Name">
      <p v-if="errors.name" class="text-red-500 text-xs"> {{ errors.name[0] }}</p>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Description
      </label>
      <textarea v-model="form.description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Product Name"></textarea>
      <p v-if="errors.description" class="text-red-500 text-xs"> {{ errors.description[0] }}</p>
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Category
      </label>
      <select v-model="form.category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" placeholder="Product Name">
        <option v-for="cat in categories" :key="cat.id" :value="cat.id"> {{ cat.name }} </option>
    </select>
    <p v-if="errors.category_id" class="text-red-500 text-xs"> category is required!</p>    
</div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
        Price
      </label>
      <input v-model="form.price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Price">
      <p v-if="errors.price" class="text-red-500 text-xs"> {{errors.price[0]}}</p>    
    </div>
    <div class="mb-4">
      <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
       Quantity
      </label>
      <input v-model="form.quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" placeholder="Quantity">
      <p v-if="errors.quantity" class="text-red-500 text-xs"> {{errors.quantity[0]}}</p>    
    </div>
  </form>
    </Modal>
  </div>
</template>


<script setup>
import { ExclamationCircleOutlined } from '@ant-design/icons-vue';
import { ref, onMounted, watch, reactive, createVNode } from "vue";
import { Modal, notification  } from "ant-design-vue";
import axios from "axios";

const isEdit = ref(false)
const products = ref([]);
const with_stock = ref(true);
const search = ref("");
const visible = ref(false);
const categories = ref([]);
const errors = ref({})
const loading = ref(false)
const product_id = ref(0)

console.log(categories)

const form = reactive({
    name: "",
    category_id: 0,
    description: "",
    quantity: 0,
    price: 0
})

const fetchAllProducts = async () => {
  const { data } = await axios.get(
    `api/products?search=${search.value}&with_stocks=${with_stock.value}`
  );
  products.value = data.data;
};

const fetchCategories = async () => {
  const { data } = await axios.get(`api/categories`);

  categories.value = data.data;
};

const showUpdateModal = (product) => {
    form.name = product.name
    form.description = product.description
    form.category_id = product.category.id
    form.price = product.price
    form.quantity = product.quantity
    isEdit.value = true
    product_id.value = product.id
    visible.value = true
}

const resetForm = () => {
    product_id.value = 0
    form.name = ""
    form.description = ""
    form.category_id = ""
    form.price = 0
    form.quantity = 0
}

const handleCancel = () => {
    visible.value = false
}

const openModal = () => {
    isEdit.value = false
    visible.value = true
}

const deleteProduct = (id) => {
    Modal.confirm({
        title: 'Do you Want to delete these Product?',
        icon: createVNode(ExclamationCircleOutlined),
        onOk() {
            axios.delete(`api/products/${id}`).then((response) => {
        notification.success({
            message: "Product Deleted Successfully!"
        })
        loading.value = false
        fetchAllProducts()
    }).catch((error) => {
        loading.value = false
        errors.value = error.response.data.errors
    })
        },
        onCancel() {
          console.log('Cancel');
        },
        class: 'test',
      });
}

const handleOk = () => {
    errors.value = {}
    loading.value = true
    if(isEdit) {
        axios.put(`api/products/${product_id.value}`, form).then((response) => {
        notification.success({
            message: "Product Updated Successfully!"
        })
        loading.value = false
        visible.value = false;
        fetchAllProducts()
        resetForm()
    }).catch((error) => {
        loading.value = false
        errors.value = error.response.data.errors
    })
    }
    else {
        axios.post(`api/products`, form).then((response) => {
        notification.success({
            message: "Product Addedd Successfully!"
        })
        loading.value = false
        visible.value = false;
        fetchAllProducts()
        resetForm()
    }).catch((error) => {
        loading.value = false
        errors.value = error.response.data.errors
    })
    }
    
 
};


watch(search, (value) => {
  fetchAllProducts();
});

watch(with_stock, (value) => {
  fetchAllProducts();
});

onMounted(() => {
  fetchAllProducts();
  fetchCategories();
});
</script>
