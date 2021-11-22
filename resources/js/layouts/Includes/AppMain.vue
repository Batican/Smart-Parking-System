<template>
     <v-main>
        <v-container fluid >
            <v-row justify="start" align="start">
                <v-col >
                    <transition name="fade">
                        <router-view></router-view>
                    </transition>
                </v-col>
            </v-row>
         </v-container>
    </v-main>
</template>