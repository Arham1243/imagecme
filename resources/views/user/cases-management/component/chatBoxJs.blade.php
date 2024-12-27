<script>
    const {
        ref
    } = Vue;

    const ChatComponent = {
        setup() {
            const TYPING_DELAY = 10;
            const message = ref('');
            const loading = ref(false);
            const conversations = ref([]);
            const chatInput = ref(null);
            const errorMessage = ref({});
            const isTyping = ref(false);

            const resizeTextarea = () => {
                const textarea = chatInput.value;
                if (textarea && textarea.scrollHeight < 140) {
                    textarea.style.height = 'auto';
                    textarea.style.height = `${textarea.scrollHeight}px`;
                }
            };

            const simulateTyping = (index, fullMessage) => {
                isTyping.value = true;
                conversations.value[index].displayReply = '';

                let i = 0;
                const interval = setInterval(() => {
                    conversations.value[index].displayReply += fullMessage[i];
                    i++;
                    if (i === fullMessage.length) {
                        clearInterval(interval);
                        isTyping.value = false;
                        conversations.value[index].isTyping = false;
                    }
                }, TYPING_DELAY);
            };

            const getApiResponse = async (userMessage) => {
                const apiKey = 'YOUR_OPENAI_API_KEY';

                try {
                    const response = await axios.post(
                        'https://api.openai.com/v1/chat/completions', {
                            model: 'gpt-4',
                            messages: [{
                                role: 'user',
                                content: userMessage,
                            }, ],
                            max_tokens: 150,
                        }, {
                            headers: {
                                'Authorization': `Bearer ${apiKey}`,
                                'Content-Type': 'application/json',
                            },
                        }
                    );

                    return {
                        status: 'success',
                        message: response.data.choices[0].message.content
                    };

                } catch (error) {
                    console.error('Error fetching the reply from OpenAI:', error);
                    return {
                        status: 'error',
                        message: error.message
                    };
                }
            };

            const submitChat = async () => {
                if (!message.value.trim()) return;
                const formattedUserMessage = message.value.replace(/\n/g, '<br>');

                conversations.value.push({
                    message: formattedUserMessage,
                    isUserMessage: true
                });

                message.value = '';

                await displayChat();
            };

            const displayChat = async () => {
                const index = conversations.value.length;
                conversations.value.push({
                    message: '',
                    isUserMessage: false,
                    isTyping: true,
                    displayReply: ''
                });


                const apiResponse = await getApiResponse(conversations.value[index - 1].message);
                if (apiResponse.status === 'error') {
                    errorMessage.value = apiResponse
                }

                simulateTyping(index, apiResponse);
            };

            const cancelChat = () => {
                if (this.controller) {
                    this.controller.abort();
                    loading.value = false;
                }
            };

            return {
                message,
                loading,
                isTyping,
                chatInput,
                errorMessage,
                conversations,
                resizeTextarea,
                submitChat,
                cancelChat,
            };
        },
    };

    Vue.createApp(ChatComponent).mount('#app');
</script>
