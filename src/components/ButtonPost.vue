<template>
    <div class="container">
        <div class="content">
            <button class="fixed-btn">
                <InteractiveIcon title="Escrever">
                    <img class="publi-icon" src="/assets/img/icons/publi.svg">
                </InteractiveIcon>
            </button>
        </div>
    </div>
</template>
<script>
import InteractiveIcon from './InteractiveIcon.vue';

export default {
    components: {
        InteractiveIcon
    }

}
</script>
<style scoped>
.container {
    position:sticky;
    z-index: 100;
}
.content {
    position:absolute;
    align-items:center
}
.fixed-btn {
    cursor:pointer;
    position:fixed;
    background:#fff;
    width: 50px;
    height: 50px;
    border-radius:50%;
    bottom: 35px;
    right: 35px;
    border-width: 1px;
}
.publi-icon{
    width: 25px;
    height: 25px;
    z-index: 101;
    right: 50px;
}
</style>