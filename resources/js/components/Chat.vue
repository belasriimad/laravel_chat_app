<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Chat
                </div>
                <div class="card-body" style="overflow: auto; height:400px" ref="messageBox">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="message in data.messages" :key="message.id">
                            <span class="fw-bold">
                                {{ message.user.name }}:
                            </span>
                            <span class="fw-normal mx-1">
                                {{ message.text }}
                            </span>
                            <small>
                                <i> {{ message.created_at }}</i>
                            </small>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <form @submit.prevent="storeMessage">
                        <div class="form-group mb-3">
                            <textarea 
                                v-model="data.message"
                                :required="true"
                                cols="30" rows="4" 
                                class="form-control"
                                placeholder="Start typing..."></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-sm btn-primary">
                                Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Online Users
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item text-success fw-bold"
                            v-for="user in data.users" :key="user.id">
                            <span style="font-size:20px">&#9900;</span>
                            {{ user.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { onMounted, reactive, ref } from "vue";

    const messageBox = ref(null);

    const data = reactive({
        users: [],
        messages: [],
        message: ''
    });

    const props = defineProps({
        user_id: {
            type: Number,
            required: true
        }
    })

    const storeMessage = async () => {
        try {
            const response = await axios.post('/api/message/send', {
                user_id: props.user_id,
                text: data.message
            });
            data.message = '';
            scrollToBottom();
        } catch (error) {
            console.log(error);
        }
    }

    const scrollToBottom = () => {
        setTimeout(() => {
            messageBox.value.scrollTop = messageBox.value.scrollHeight;
        }, 700);
    }

    const fetchMessages = async () => {
        try {
            const response = await axios.get('/api/messages');
            data.messages = response.data;
        } catch (error) {
            console.log(error);
        }
    }

    onMounted(() => {
        fetchMessages();
        Echo.join('chat')
            .here((users) => {
                data.users = users;
            }).joining((user) => {
                data.users.push(user);
            }).leaving((user) => {
                data.users = data.users.filter(item => item.id !== user.id);
            }).listen('StoreMessageEvent', (event) => {
                const message = event.message;
                data.messages.push(message);
                scrollToBottom();
            });
    });
</script>

<style>

</style>