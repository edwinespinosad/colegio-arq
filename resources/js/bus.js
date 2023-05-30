import { reactive, provide } from 'vue'

const eventBus = reactive({})
export function setupEventBus(app) {
    provide('eventBus', eventBus)
}

export function emitEvent(event, data) {
    if (eventBus[event]) {
        eventBus[event].forEach(callback => {
            callback(data)
        })
    }
}

export function onEvent(event, callback) {
    if (!eventBus[event]) {
        eventBus[event] = []
    }
    eventBus[event].push(callback)
}
