<div class="chat chat-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12" v-if="loadingChats">
                <div class="loader loader--sm mx-auto d-block"></div>
            </div>
            <div class="col-md-9">
                <div class="chat-conversations">
                    <div v-for="(conversation, index) in conversations" :key="index">
                        <div v-if="conversation.images && conversation.isUserMessage" class="user-images">
                            <a :href="image.url" data-fancybox="gallery"
                                v-for="(image, imgIndex) in conversation.images" :key="imgIndex"
                                class="user-images__mask">
                                <img :src="image.url" alt="Uploaded image" class="uploaded-image" />
                            </a>
                        </div>
                        <div v-if="conversation.isUserMessage" class="user-message">
                            <span v-html="conversation.message"></span>
                        </div>
                        <div v-else class="chat-reply">
                            <div class="chat-reply__icon">
                                <img src="https://cdn.worldvectorlogo.com/logos/chatgpt-6.svg" alt="image"
                                    class="imgFluid" loading="lazy">
                            </div>
                            <div :class="`chat-reply__message ${errorMessage.status === 'error' ? 'pt-5' : ''}`">
                                <div v-if="!conversation.isError">
                                    <span class="message-text"
                                        v-html="conversation.displayReply.replace(/\n/g, '<br>')"></span>
                                    <span class="cursor" v-if="conversation.isTyping"></span>
                                </div>
                                <div v-else v-if="index === conversations.length - 1" class="custom-alert">
                                    <div class="icon"><i class='bx bx-info-circle'></i></div>
                                    <div class="content">@{{ errorMessage.message }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="!conversations[conversations.length - 1]?.isError" class="chat-box">
                    <form @submit.prevent="submitChat" class="chat-box__form">
                        <div class="uploaded-images-wrapper" v-if="showUploadedImages.length> 0">
                            <div v-for="(image, index) in showUploadedImages" :key="index"
                                class="uploaded-image">
                                <button type="button" class="remove-file" data-tooltip="tooltip" title="Remove file"
                                    @click="removeImage(index)">
                                    <i class="bx bx-x"></i>
                                </button>
                                <a :href="image" data-fancybox="gallery" class="image-mask">
                                    <img :src="image" alt="Uploaded preview" />
                                </a>
                            </div>
                        </div>
                        <textarea placeholder="Message" rows="1" ref="chatInput" class="chat-input" v-model="message"
                            @input="resizeTextarea" @keydown="handleKeydown"> </textarea>
                        <div class="action-wrapper">
                            <div class="actions-btn">
                                <input type="file" multiple name="files[]" id="attachFiles" class="d-none"
                                    @change="handleFileInput" accept="image/*" />
                                <label for="attachFiles" data-tooltip="tooltip" title="Attach Files" type="submit"
                                    class="icon-btn">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M9 7C9 4.23858 11.2386 2 14 2C16.7614 2 19 4.23858 19 7V15C19 18.866 15.866 22 12 22C8.13401 22 5 18.866 5 15V9C5 8.44772 5.44772 8 6 8C6.55228 8 7 8.44772 7 9V15C7 17.7614 9.23858 20 12 20C14.7614 20 17 17.7614 17 15V7C17 5.34315 15.6569 4 14 4C12.3431 4 11 5.34315 11 7V15C11 15.5523 11.4477 16 12 16C12.5523 16 13 15.5523 13 15V9C13 8.44772 13.4477 8 14 8C14.5523 8 15 8.44772 15 9V15C15 16.6569 13.6569 18 12 18C10.3431 18 9 16.6569 9 15V7Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </label>
                                <button v-if="isTyping" class="circle-btn" :disabled="!message.trim() || loading">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="icon-lg">
                                        <rect x="7" y="7" width="10" height="10" rx="1.25"
                                            fill="currentColor"></rect>
                                    </svg>
                                </button>
                                <button v-else="isTyping" class="circle-btn" :disabled="!message.trim() || loading">
                                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="icon-2xl">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M15.1918 8.90615C15.6381 8.45983 16.3618 8.45983 16.8081 8.90615L21.9509 14.049C22.3972 14.4953 22.3972 15.2189 21.9509 15.6652C21.5046 16.1116 20.781 16.1116 20.3347 15.6652L17.1428 12.4734V22.2857C17.1428 22.9169 16.6311 23.4286 15.9999 23.4286C15.3688 23.4286 14.8571 22.9169 14.8571 22.2857V12.4734L11.6652 15.6652C11.2189 16.1116 10.4953 16.1116 10.049 15.6652C9.60265 15.2189 9.60265 14.4953 10.049 14.049L15.1918 8.90615Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="message">© <?= date('Y') ?> - {{ env('APP_NAME') }} . All Rights Reserved</div>
                </div>
                <div v-if="conversations.length && conversations[conversations.length - 1].isError"
                    class="error-sceen">
                    There was an error generating a response
                    <a href="" class="chat-btn"><svg width="18" height="18" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg" class="icon-sm">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M4.47189 2.5C5.02418 2.5 5.47189 2.94772 5.47189 3.5V5.07196C7.17062 3.47759 9.45672 2.5 11.9719 2.5C17.2186 2.5 21.4719 6.75329 21.4719 12C21.4719 17.2467 17.2186 21.5 11.9719 21.5C7.10259 21.5 3.09017 17.8375 2.53689 13.1164C2.47261 12.5679 2.86517 12.0711 3.4137 12.0068C3.96223 11.9425 4.45901 12.3351 4.5233 12.8836C4.95988 16.6089 8.12898 19.5 11.9719 19.5C16.114 19.5 19.4719 16.1421 19.4719 12C19.4719 7.85786 16.114 4.5 11.9719 4.5C9.7515 4.5 7.75549 5.46469 6.38143 7H9C9.55228 7 10 7.44772 10 8C10 8.55228 9.55228 9 9 9H4.47189C3.93253 9 3.4929 8.57299 3.47262 8.03859C3.47172 8.01771 3.47147 7.99677 3.47189 7.9758V3.5C3.47189 2.94772 3.91961 2.5 4.47189 2.5Z"
                                fill="currentColor"></path>
                        </svg>Try Again</a>
                </div>
            </div>
        </div>
    </div>
</div>
