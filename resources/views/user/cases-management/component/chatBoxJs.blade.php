<script>
    const {
        ref,
        onMounted
    } = Vue;

    const ChatComponent = {
        setup() {
            const message = ref('');
            const loading = ref(false);
            const response = ref('');
            const chatInput = ref(null);

            const resizeTextarea = () => {
                const textarea = chatInput.value;
                if (textarea && textarea.scrollHeight < 140) {
                    textarea.style.height = 'auto';
                    textarea.style.height = `${textarea.scrollHeight}px`;
                }
            };

            const submitChat = async () => {
                if (!message.value.trim()) return
                loading.value = true;
                try {

                } catch (error) {
                    console.log(error)
                } finally {
                    loading.value = false;
                    message.value = '';
                }
            };

            const cancelChat = () => {
                if (this.controller) {
                    this.controller.abort();
                    loading.value = false;
                }
            }

            return {
                message,
                loading,
                chatInput,
                resizeTextarea,
                submitChat,
                cancelChat,
            };
        },
    };

    Vue.createApp(ChatComponent).mount('#app');
</script>
