<template>
    <b-list-group-item>
        <b-row>
            <b-col cols="9" align-self="center">
                <b-card-text v-if="!task.isEdit"  @click="task.isEdit = true" >{{task.title}}</b-card-text>
                <b-input v-else type="text" :autofocus="true" @keyup.enter="task.isEdit = false" @blur="task.isEdit = false" v-model="task.title"></b-input>
            </b-col>
            <b-col align-self="center">
                <b-checkbox v-b-tooltip.hover title="Done" v-model="task.isDone"></b-checkbox>
            </b-col>
            <b-col>
                <b-button variant="outline-danger"  @click="del(task)" size="sm">
                    <b-icon icon="x" aria-hidden="true"></b-icon>
                </b-button>
            </b-col>
        </b-row>
    </b-list-group-item>
</template>

<script>
    export default {
        props: ['task','del'],
    }
</script>
