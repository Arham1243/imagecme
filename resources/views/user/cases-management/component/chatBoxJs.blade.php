<script>
    const {
        ref
    } = Vue;

    const ChatComponent = {
        setup() {
            const API_KEY = '{{ env('OPENAI_API_KEY') }}';
            const TYPING_DELAY = 5;
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
                try {

                    const response = await axios.post(
                        'https://api.openai.com/v1/chat/completions', {
                            model: 'gpt-4',
                            messages: [{
                                role: 'user',
                                content: userMessage,
                            }, ],
                        }, {
                            headers: {
                                'Authorization': `Bearer ${API_KEY}`,
                                'Content-Type': 'application/json',
                            },
                        }
                    );

                    const aiMessage = response.data.choices[0].message.content;

                    return {
                        status: 'success',
                        message: aiMessage
                    };

                } catch (error) {
                    return {
                        status: 'error',
                        message: error.message
                    };
                }
            };

            const handleKeydown = (event) => {
                if (event.key === 'Enter' && !loading.value) {
                    if (event.shiftKey) {
                        return;
                    } else {
                        submitChat();
                        event.preventDefault();
                    }
                }
            };

            const submitChat = async () => {
                if (!message.value.trim() || loading.value) return;

                loading.value = true;

                try {
                    const formattedUserMessage = message.value.replace(/\n/g, '<br>');

                    conversations.value.push({
                        message: formattedUserMessage,
                        isUserMessage: true
                    });

                    conversations.value.push({
                        message: '',
                        isUserMessage: false,
                        isTyping: true,
                        displayReply: ''
                    });

                    message.value = '';
                    chatInput.value.style.height = 'auto';

                    const index = conversations.value.length - 1;

                    const apiResponse = await getApiResponse(formattedUserMessage);

                    if (apiResponse.status === 'error') {
                        errorMessage.value = apiResponse;
                    }

                    conversations.value[index].message = apiResponse.message;

                    simulateTyping(index, apiResponse
                        .message);

                } catch (error) {
                    console.error("Error fetching API response:", error);
                } finally {
                    loading.value = false;
                }
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
                handleKeydown,
                conversations,
                resizeTextarea,
                submitChat,
                cancelChat,
            };
        },
    };

    Vue.createApp(ChatComponent).mount('#app');
</script>
