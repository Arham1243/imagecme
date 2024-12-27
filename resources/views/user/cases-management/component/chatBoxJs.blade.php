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
            const uploadedImages = ref([]);
            const showUploadedImages = ref([]);
            const chatInput = ref(null);
            const errorMessage = ref({});
            const isTyping = ref(false);
            const isError = ref(false);

            const handleFileInput = (event) => {
                const files = event.target.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        uploadedImages.value.push(e.target.result);
                        showUploadedImages.value.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            }

            const removeImage = (index) => {
                uploadedImages.value.splice(index, 1);
                showUploadedImages.value.splice(index, 1);
            }

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
                    const conversationHistory = conversations.value.map(conv => ({
                        role: conv.isUserMessage ? 'user' : 'assistant',
                        content: [{
                            type: 'text',
                            text: conv.message
                        }]
                    }));

                    const userContent = [{
                        type: 'text',
                        text: userMessage
                    }];

                    if (uploadedImages.value.length > 0) {
                        const imageContents = uploadedImages.value.map(url => ({
                            type: 'image_url',
                            image_url: {
                                url
                            }
                        }));
                        userContent.push(...imageContents);
                    }

                    conversationHistory.push({
                        role: 'user',
                        content: userContent
                    });


                    const response = await axios.post(
                        'https://api.openai.com/v1/chat/completions', {
                            model: 'gpt-4o',
                            messages: conversationHistory,
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
                        message: error.response.data.error.message
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

            const resetValues = () => {
                message.value = '';
                showUploadedImages.value = []
                chatInput.value.style.height = 'auto';
            }

            const submitChat = async () => {
                if (!message.value.trim() || loading.value) return;

                loading.value = true;
                isError.value = false;

                try {
                    const formattedUserMessage = message.value.replace(/\n/g, '<br>');

                    const uploadedImageUrls = uploadedImages.value.map(url => ({
                        type: 'image_url',
                        url
                    }));

                    const userMessage = {
                        message: formattedUserMessage,
                        isUserMessage: true,
                        isError: false
                    };

                    if (uploadedImageUrls.length > 0) {
                        userMessage.images = uploadedImageUrls;
                    }

                    conversations.value.push(userMessage);

                    conversations.value.push({
                        message: '',
                        isUserMessage: false,
                        isTyping: true,
                        displayReply: '',
                        isError: false
                    });

                    const index = conversations.value.length - 1;

                    resetValues();

                    const apiResponse = await getApiResponse(formattedUserMessage);

                    if (apiResponse.status === 'error') {
                        errorMessage.value = apiResponse;
                        conversations.value[index].isError = true;
                    } else {
                        conversations.value[index].isError = false;
                    }

                    conversations.value[index].message = apiResponse.message;
                    simulateTyping(index, apiResponse.message);

                } catch (error) {
                    errorMessage.value = {
                        message: error.message
                    };

                    conversations.value[conversations.value.length - 1].isError = true;
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
                isError,
                chatInput,
                errorMessage,
                handleKeydown,
                conversations,
                resizeTextarea,
                submitChat,
                cancelChat,
                handleFileInput,
                removeImage,
                uploadedImages,
                showUploadedImages
            };
        },
    };

    Vue.createApp(ChatComponent).mount('#app');
</script>
