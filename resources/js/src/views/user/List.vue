<template>
    <div id="data-list-list-user" class="data-list-container">
        <vs-table :data="users">

            <template slot="thead">
                <vs-th>{{$t('No')}}</vs-th>
                <vs-th>{{$t('User.Name')}}</vs-th>
                <vs-th>{{$t('User.EmployeeNumber')}}</vs-th>
                <vs-th>{{$t('User.Rank')}}</vs-th>
                <vs-th>{{$t('User.Email')}}</vs-th>
                <vs-th>{{$t('User.Phone')}}</vs-th>
                <vs-th>{{$t('Action')}}</vs-th>

            </template>

<!--            <template slot-scope="{data}">-->
<!--                <vs-tr :key="indextr" v-for="(tr, indextr) in data">-->
<!--                    <vs-td >-->
<!--                        {{indextr + 1}}-->
<!--                    </vs-td>-->
<!--                    <vs-td>-->
<!--                        {{data[indextr].first_name + data[indextr].last_name}}-->
<!--                    </vs-td>-->
<!--                    <vs-td>-->
<!--                        {{data[indextr].employee_number}}-->
<!--                    </vs-td>-->
<!--                    <vs-td >-->
<!--                        {{data[indextr].rank}}-->
<!--                    </vs-td>-->
<!--                    <vs-td >-->
<!--                        {{data[indextr].email}}-->
<!--                    </vs-td>-->
<!--                    <vs-td >-->
<!--                        {{data[indextr].phone}}-->
<!--                    </vs-td>-->
<!--                </vs-tr>-->
<!--            </template>-->
        </vs-table>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                'tableList': [
                    'vs-th: Component',
                    'vs-tr: Component',
                    'vs-td: Component',
                    'thread: Slot',
                    'tbody: Slot',
                    'header: Slot'
                ],
                users: [
                    {
                        "id": 1,
                        "name": "Leanne Graham",
                        "username": "Bret",
                        "email": "Sincere@april.biz",
                        "website": "hildegard.org",
                    },
                    {
                        "id": 2,
                        "name": "Ervin Howell",
                        "username": "Antonette",
                        "email": "Shanna@melissa.tv",
                        "website": "anastasia.net",
                    },
                    {
                        "id": 3,
                        "name": "Clementine Bauch",
                        "username": "Samantha",
                        "email": "Nathan@yesenia.net",
                        "website": "ramiro.info",
                    },
                    {
                        "id": 4,
                        "name": "Patricia Lebsack",
                        "username": "Karianne",
                        "email": "Julianne.OConner@kory.org",
                        "website": "kale.biz",
                    },
                    {
                        "id": 5,
                        "name": "Chelsey Dietrich",
                        "username": "Kamren",
                        "email": "Lucio_Hettinger@annie.ca",
                        "website": "demarco.info",
                    },
                    {
                        "id": 6,
                        "name": "Mrs. Dennis Schulist",
                        "username": "Leopoldo_Corkery",
                        "email": "Karley_Dach@jasper.info",
                        "website": "ola.org",
                    },
                    {
                        "id": 7,
                        "name": "Kurtis Weissnat",
                        "username": "Elwyn.Skiles",
                        "email": "Telly.Hoeger@billy.biz",
                        "website": "elvis.io",
                    },
                    {
                        "id": 8,
                        "name": "Nicholas Runolfsdottir V",
                        "username": "Maxime_Nienow",
                        "email": "Sherwood@rosamond.me",
                        "website": "jacynthe.com",
                    },
                    {
                        "id": 9,
                        "name": "Glenna Reichert",
                        "username": "Delphine",
                        "email": "Chaim_McDermott@dana.io",
                        "website": "conrad.com",
                    },
                    {
                        "id": 10,
                        "name": "Clementina DuBuque",
                        "username": "Moriah.Stanton",
                        "email": "Rey.Padberg@karina.biz",
                        "website": "ambrose.net",
                    },
                ]
            }
        },
    }
</script>

<style scoped>

</style>
