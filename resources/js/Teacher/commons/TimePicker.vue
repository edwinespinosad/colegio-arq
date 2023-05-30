<template>
    <div class="time-picker">
        <v-text-field
            v-model="time"
            :value="formatTime(time)"
            prepend-icon="mdi-clock-time-four-outline"
            solo
            hide-details
            readonly
            @click:prepend="togglePicker"
        ></v-text-field>
        <div class="picker" v-if="isOpen">
            <div class="clock">
                <div class="hour-hand" :style="hourHandStyle"></div>
                <div class="minute-hand" :style="minuteHandStyle"></div>
                <div class="center-circle"></div>
                <div
                    class="marker"
                    v-for="marker in markers"
                    :key="marker"
                    :style="markerStyle(marker)"
                    @click="setTimeFromMarker(marker)"
                ></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TimePicker",
    data() {
        return {
            time: '',
            isOpen: false,
            markers: Array.from({ length: 12 }, (_, i) => i + 1),
        };
    },
    computed: {
        hourHandStyle() {
            const rotation = this.getHourRotation();
            return {
                transform: `rotate(${rotation}deg)`,
            };
        },
        minuteHandStyle() {
            const rotation = this.getMinuteRotation();
            return {
                transform: `rotate(${rotation}deg)`,
            };
        },
    },
    methods: {
        togglePicker() {
            this.isOpen = !this.isOpen;
        },
        updateTime() {
            // Realiza las validaciones o acciones necesarias con el valor de la hora seleccionada
            console.log(this.time);
        },
        setTimeFromMarker(marker) {
            this.time = marker.toString().padStart(2, '0') + ':00';
            this.isOpen = false;
            this.updateTime();
        },
        getHourRotation() {
            if (this.time) {
                const [hour] = this.time.split(':');
                return (hour % 12) * 30;
            }
            return 0;
        },
        getMinuteRotation() {
            if (this.time) {
                const [, minute] = this.time.split(':');
                return (minute / 60) * 360;
            }
            return 0;
        },
        formatTime(time) {
            if (time) {
                const [hour, minute] = time.split(':');
                return `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`;
            }
            return '';
        },
        markerStyle(marker) {
            const rotation = (marker - 3) * 30;
            return {
                transform: `rotate(${rotation}deg)`,
            };
        },
    },
};
</script>

<style scoped>
.time-picker {
    position: relative;
    display: inline-block;
}

.picker {
    position: absolute;
    top: 100%;
    left: 0;
    width: 250px;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.clock {
    position: relative;
    width: 200px;
    height: 200px;
    background-color: #f0f0f0;
    border-radius: 50%;
    border: 2px solid #ccc;
    display: flex;
    justify-content: center;
    align-items: center;
}

.hour-hand,
.minute-hand {
    position: absolute;
    background-color: #333;
    transform-origin: bottom center;
    transition: transform 0.3s ease-in-out;
}

.hour-hand {
    width: 6px;
    height: 60px;
    border-radius: 4px 4px 0 0;
}

.minute-hand {
    width: 4px;
    height: 80px;
    border-radius: 4px 4px 0 0;
}

.center-circle {
    position: absolute;
    width: 10px;
    height: 10px;
    background-color: #333;
    border-radius: 50%;
}

.marker {
    position: absolute;
    top: 5px;
    left: calc(50% - 2px);
    width: 4px;
    height: 20px;
    background-color: #333;
    transform-origin: bottom center;
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
}

.marker:hover {
    transform: scale(1.2);
}
</style>
