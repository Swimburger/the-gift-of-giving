<template>
    <div class="mt-4">
        <div id="pick-a-charity" class="mt-6 lg:mt-12">
            <h2 class="mb-3">Our Charities</h2>
            <div id="charities-list">
                <div
                    class="charity-item flex flex-col hover:drop-shadow-md"
                    v-for="(charity, code) in charities"
                    :key="code"
                >
                    <div id="charity-header" class="drop-shadow-md">
                        <img
                            :src="'/images/backgrounds/' + charity.image"
                            :alt="`Background header image for ${charity.name}`"
                            class="rounded-t-md"
                        />
                    </div>
                    <div id="charity-details" class="px-4 pt-4">
                        <h3 class="mb-4">{{ charity.name }}</h3>
                        <Markdown :source="charity.description" />
                    </div>
                    <div id="key-actions" v-if="charity.actions">
                        <h4>Key Actions</h4>
                        <ul>
                            <li v-for="action in charity.actions" :key="action">
                                {{ action }}
                            </li>
                        </ul>
                    </div>
                    <div id="social-connections" v-if="charity.social">
                        <h4>Connect Socially</h4>
                        <div class="flex">
                            <a
                                v-for="(username, platform) in charity.social"
                                :key="platform"
                                :href="`https://${platform}.com/${username}`"
                                :title="`Follow ${charity.name} on ${ucfirst(platform)}`"
                                class="mr-2"
                                target="_blank"
                            >
                                <img
                                    :src="`/images/social-media-icons/${platform}.png`"
                                    width="24"
                                    class="contrast-50 grayscale hover:contrast-100 hover:grayscale-0 ease-in-out duration-200"
                                    :alt="`Follow ${charity.name} on ${ucfirst(platform)}`"
                            /></a>
                        </div>
                    </div>

                    <div id="donate-wrapper" class="pt-4">
                        <button
                            class="donate rounded-b-md w-full py-8 font-bold text-white uppercase bg-purple-900 hover:bg-purple-800 ease-in-out duration-200"
                        >Donate &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Markdown from "vue3-markdown-it";

export default {
    data() {
        return {
            api: "http://localhost:8080",
            charities: [],
    };
},
components: {
    Markdown,
},
name: "CharitiesList",
methods: {
    async fetchData() {
        const res = await fetch(`${this.api}/charities`, {
            mode: "cors",
        });
        this.charities = await res.json();
        console.log(this.charities);
    },
    ucfirst: function(str) {
        if (!str) return str;
            return str[0].toUpperCase() + str.slice(1);
        },
    },
    mounted() {
        this.fetchData();
    },
};
</script>

<style scoped></style>
