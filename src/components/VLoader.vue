<template>
    <div :class="type"></div>   
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
            }
        }
    }
</script>

<style scoped>

    :host([linear]) div {
        display: block;
        height: 4px;
        width: 30%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        position: absolute;
        overflow: hidden;
        background-color: var(--base-color);
        margin: auto;
        border: 1px solid red;
    }

    :host([linear]) div:before {
        display: block;
        position: absolute;
        content: "";
        left: -200px;
        width: 200px;
        height: 4px;
        background-color: var(--base-color);
        animation: loading 1s linear infinite;
    }
        
    @keyframes loading {
        from {
            left: -200px;
            width: 30%;
        }
        50% {
            width: 30%;
        }
        70% {
            width: 70%;
        }
        80% {
            left: 50%;
        }
        95% {
            left: 120%;
        }
        to {
            left: 100%;
        }
    }
    

    div.radial {
        display: block;
        border: 3px solid var(--grey);
        border-top: 3px solid var(--accent);
        border-radius: 50%;
        width: 48px;
        height: 48px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>