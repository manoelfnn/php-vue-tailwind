<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>

<body class="h-full bg-gray-200">

    <div id="app" class="h-full">

        <div class="container h-full p-10 flex items-center justify-center">
            <div v-if="users" class="flex w-9/12 max-h-full h-full p-5 shadow-md border rounded-xl bg-white">
                <div class="left-content w-1/4 overflow-scroll overflow-x-hidden max-h-full h-full pr-5">
                    <ul class="flex gap-1 flex-col">
                        <li v-for="user in users" :key="user.id"
                            class="border p-1 px-5 cursor-pointer rounded-xl max-y text-sm text-gray-700"
                            @click="view(user.id)"
                            :class="{ 'bg-blue-700 text-white': currentUser && user.id == currentUser.id}">
                            {{user.first_name}} {{user.last_name}}
                        </li>
                    </ul>
                </div>
                <div class="center-content w-3/4 ml-2 p-2">
                    <div v-if="currentUser">
                        <div class="flex items-center gap-10">
                            <div class="w-content">
                                <img :src="currentUser.avatar" class="shadow p-1 border rounded-full" width="150"
                                    height="150">
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-bold text-3xl">{{currentUser.first_name}} {{currentUser.last_name}}
                                </div>
                                <div class="font-thin text-sm">{{currentUser.email}}</div>
                                <div class="font-thin text-xs">{{currentUser.phone_number}}</div>
                                <div class="mt-2 pt-2 border-t">
                                    <div class="font-bold text-xs">{{currentUser.address.city}} /
                                        {{currentUser.address.state}} /
                                        {{currentUser.address.country}}</div>
                                    <div class="font-thin text-xs">{{currentUser.address.street_name}},
                                        {{currentUser.address.street_address}}</div>
                                    <div class="font-thin text-xs">{{currentUser.address.zip_code}}</div>

                                </div>
                            </div>
                        </div>
                        <div class="border-t mt-2 pt-2 w-full">
                            <iframe width="100%" height="250" :src="'https://maps.google.com/maps?q=' + 
                                currentUser.address.city + ',' + 
                                currentUser.address.state + ',' + 
                                currentUser.address.street_name + ',' + 
                                currentUser.address.country + '&z=14&output=embed'"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="!users" class="text-center">

                <div v-if="loading" role="status">
                    <svg aria-hidden="true"
                        class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor" />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill" />
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>

                <button v-if="!loading" type="button" @click="loadUser()"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Carregar
                    usuários</button>
            </div>

        </div>
    </div>


    <script>
        const {
            createApp,
            ref
        } = Vue

        createApp({
            setup() {
                const message = ref('Hello vue!');
                const users = ref(null);
                const loading = ref(false);
                const currentUser = ref(null);

                function loadUser() {
                    loading.value = true;
                    fetch('Controllers/UserController.php')
                        .then(response => response.json())
                        .then(data => {
                            users.value = data;
                            loading.value = false;
                        });
                }

                function view(id) {
                    currentUser.value = users.value.find((user) => user.id == id);
                }

                return {
                    message,
                    users,
                    currentUser,
                    loading,
                    loadUser,
                    view
                }
            },
            data() {
                return {}
            }
        }).mount('#app');
    </script>



</body>

</html>