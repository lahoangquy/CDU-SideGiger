<template>
    <div class="overlay" v-show="show">
        <div class="popup-modal">
            <div class="relative px-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <!-- Modal header -->
                    <div class="flex justify-end p-2">
                        <button
                            type="button"
                            class="button-close"
                            @click="$emit('close')"
                        >
                            <svg-vue icon="close" class="w-5 h-5" />
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 pt-0 text-center">
                        <svg-vue
                            :icon="icon"
                            class="
                                mx-auto
                                mb-4
                                w-14
                                h-14
                                text-gray-400
                                dark:text-gray-200
                            "
                        />
                        <h3><slot /></h3>
                        <button
                            @click.prevent="$emit('handle-confirm')"
                            type="button"
                            class="button-action"
                        >
                            {{ actionText }}
                        </button>
                        <button
                            v-if="showCloseButton"
                            @click="$emit('close')"
                            type="button"
                            class="button-cancel"
                        >
                            {{ closeText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        icon: {
            type: String,
            default: "warning",
        },
        show: {
            type: Boolean,
            default: false,
        },
        showCloseButton: {
            type: Boolean,
            default: () => true,
        },
        closeText: {
            type: String,
            default: "Close",
        },
        actionText: {
            type: String,
            default: "Yes, I'm sure",
        },
        popupId: {
            type: String,
            default: "popup-modal",
        },
    },
};
</script>

<style lang="scss" scoped>
.overlay {
    @apply bg-gray-700 bg-opacity-50 dark:bg-opacity-50 fixed inset-0 z-10;
}
.popup-modal {
    @apply overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 flex justify-center items-center md:inset-0 h-modal sm:h-full;

    h3 {
        @apply mb-5 text-lg font-normal text-gray-500 dark:text-gray-400;
    }

    .button {
        &-close {
            @apply text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white;
        }
        &-action {
            @apply text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2;
        }

        &-cancel {
            @apply text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600;
        }
    }
}
</style>
