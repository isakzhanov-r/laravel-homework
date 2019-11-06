<template>
    <md-card class="md-card-weather" v-if="weather">
        <md-card-header>
            <md-icon :md-src="getIcon()"/>
        </md-card-header>

        <md-card-content>
            <p class="category">Брянск</p>
            <h4 class="title">{{ getCondition(weather.fact.condition) }}</h4>
            <h5 class="title">Температура: {{ weather.fact.temp }} ℃</h5>
        </md-card-content>

        <md-card-expand>
            <md-card-actions md-alignment="space-between">
                <div class="stats">
                    <md-icon>date_range</md-icon>
                    {{ getDate(weather.fact.obs_time) }}
                </div>

                <md-card-expand-trigger>
                    <md-button class="md-icon-button">
                        <md-icon>keyboard_arrow_down</md-icon>
                    </md-button>
                </md-card-expand-trigger>
            </md-card-actions>

            <md-card-expand-content>
                <md-card-content>
                    <p>Ощущаемая температура: <b v-text="weather.fact.feels_like"/>(°C).</p>
                    <br>
                    <p>Скорость ветра: <b v-text="weather.fact.wind_speed"/> (в м/с).</p>
                    <br>
                    <p>Скорость порывов ветра: <b v-text="weather.fact.wind_gust"/> (в м/с).</p>
                </md-card-content>
            </md-card-expand-content>
        </md-card-expand>
    </md-card>
</template>

<script>
    export default {
        name: 'WeatherWidget',
        data: () => ({
            weather: []
        }),
        created() {
            this.getWeather();
        },
        methods: {
            getWeather() {
                axios.get('api/weather/yandex')
                    .then(response => {
                        this.weather = response.data;
                    });
            },
            getIcon() {
                if (this.weather) {
                    var url = 'https://yastatic.net/weather/i/icons/blueye/color/svg/';
                    return url + this.weather.fact.icon + '.svg';
                }
                return null;
            },
            getDate(timestamp) {
                var date = new Date(timestamp * 1000);
                return date.toLocaleString('ru-RU');
            },
            getCondition(condition) {
                var array = {
                    'clear': '— ясно',
                    'partly-cloudy': '— малооблачно',
                    'cloudy': '— облачно с прояснениями',
                    'overcast': '— пасмурно',
                    'partly-cloudy-and-light-rain': '— небольшой дождь',
                    'partly-cloudy-and-rain': '— дождь',
                    'overcast-and-rain': '— сильный дождь',
                    'overcast-thunderstorms-with-rain': '— сильный дождь, гроза',
                    'cloudy-and-light-rain': '— небольшой дождь',
                    'overcast-and-light-rain': '— небольшой дождь',
                    'cloudy-and-rain': ' — дождь',
                    'overcast-and-wet-snow': '— дождь со снегом',
                    'partly-cloudy-and-light-snow': '— небольшой снег',
                    'partly-cloudy-and-snow': '— снег',
                    'overcast-and-snow': '— снегопад',
                    'cloudy-and-light-snow': '— небольшой снег',
                    'overcast-and-light-snow': '— небольшой снег',
                    'cloudy-and-snow': '— снег'
                };
                return array[condition];
            }
        }
    };
</script>

<style scoped>

</style>
