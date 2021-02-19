<template>
    <v-row align="center" justify="center">
        <v-col cols="12">
            <v-card :loading="loading" class="elevation-12 ">
                <v-toolbar color="grey lighten-2 " dark flat>
                    <v-toolbar-title class="black--text"
                        >Email informations</v-toolbar-title
                    >
                    <div class="flex-grow-1"></div>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-text-field
                            label="From"
                            v-model="form.from"
                            prepend-icon="person"
                            type="text"
                            :error-messages="fromErrors"
                            :counter="60"
                            @input="$v.form.from.$touch()"
                            @blur="$v.form.from.$touch()"
                        ></v-text-field>
                        <v-text-field
                            label="To"
                            v-model="form.to"
                            prepend-icon="person"
                            type="text"
                            :error-messages="toErrors"
                            :counter="60"
                            @input="$v.form.to.$touch()"
                            @blur="$v.form.to.$touch()"
                        ></v-text-field>
                        <v-text-field
                            label="Subject"
                            v-model="form.subject"
                            prepend-icon="person"
                            type="text"
                            :error-messages="subjectErrors"
                            :counter="120"
                            @input="$v.form.subject.$touch()"
                            @blur="$v.form.subject.$touch()"
                        ></v-text-field>


                        <v-textarea

                            filled
                            label="Text Content"
                            auto-grow
                            rows="2"
                            row-height="30"
                            shaped
                            counter="400"
                            required
                            v-model="form.text_content"
                            @input="$v.form.text_content.$touch()"
                            @blur="$v.form.text_content.$touch()"
                            :error-messages="textContentErrors"




                            >
                          </v-textarea>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <div class="flex-grow-1"></div>
                    <v-btn width="100%" @click="handleSubmit()" color="primary">
                        Send</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import { validationMixin } from "vuelidate";
import {
    required,
    maxLength,
    minLength,
    email,
    sameAs
} from "vuelidate/lib/validators";
export default {
     mixins: [validationMixin],
     validations: {
         form:{
            subject: { required, maxLength: maxLength(60),minLength : minLength(3),
                  serverFailed : function(){
                               return !this.hasServerError('name');
                  }
                },
            to: { required,email,maxLength: maxLength(60),minLength : minLength(3),
                      serverFailed : function(){

                                   return !this.hasServerError('to');
                      }
                    },
            from: { required,email,maxLength: maxLength(60),minLength : minLength(3),
                      serverFailed : function(){

                                   return !this.hasServerError('from');
                      }
                    },
            text_content: { required,maxLength: maxLength(400),minLength : minLength(3),
                      serverFailed : function(){

                                   return !this.hasServerError('text_content');
                      }
                    },

         }
     },
    data: () => ({ form:{
                    subject:'',
                    to:'',
                    from:'',
                    text_content:''
                        },


                    errors:[],
                    errorMessage:{},

                    loading:false
             }),

            computed: {


              subjectErrors: {
                  get:function(){
                  const errors = []
                  //console.log('oi')
                  if (!this.$v.form.subject.$dirty) return errors
                  !this.$v.form.subject.maxLength && errors.push('Nome deve ter no máximo 60 caracteres.')
                  !this.$v.form.subject.required && errors.push('Nome é obrigatório.')
                  !this.$v.form.subject.minLength && errors.push('Nome deve ter pelo menos 3 caracteres.')
                  !this.$v.form.subject.serverFailed && errors.push(this.errorMessage.subject.join(" "))
                  delete this.errorMessage['subject'];
                  return errors
                }
              }
              ,fromErrors: {
                  get:function(){
                  const errors = []
                  if (!this.$v.form.from.$dirty) return errors
                  !this.$v.form.from.maxLength && errors.push('E-mail deve ter no máximo 60 caracteres.')
                  !this.$v.form.from.required && errors.push('E-mail é obrigatório.')
                  !this.$v.form.from.email && errors.push('E-mail inválido.')
                  !this.$v.form.from.minLength && errors.push('Email deve ter pelo menos 3 caracteres.')
                  !this.$v.form.from.serverFailed && errors.push(this.errorMessage.from.join(" "))
                  delete this.errorMessage['from'];
                  return errors
                }
              },
              toErrors: {
                  get:function(){
                  const errors = []
                  if (!this.$v.form.to.$dirty) return errors
                  !this.$v.form.to.maxLength && errors.push('E-mail deve ter no máximo 60 caracteres.')
                  !this.$v.form.to.required && errors.push('E-mail é obrigatório.')
                  !this.$v.form.to.email && errors.push('E-mail inválido.')
                  !this.$v.form.to.minLength && errors.push('Email deve ter pelo menos 3 caracteres.')
                  !this.$v.form.to.serverFailed && errors.push(this.errorMessage.to.join(" "))
                  delete this.errorMessage['to'];
                  return errors
                }
              }
              ,
              textContentErrors: {
                  get:function(){
                  const errors = []
                  if (!this.$v.form.text_content.$dirty) return errors
                  !this.$v.form.text_content.maxLength && errors.push('E-mail deve ter no máximo 60 caracteres.')
                  !this.$v.form.text_content.required && errors.push('E-mail é obrigatório.')
                  !this.$v.form.text_content.minLength && errors.push('Email deve ter pelo menos 3 caracteres.')
                  !this.$v.form.text_content.serverFailed && errors.push(this.errorMessage.text_content.join(" "))
                  delete this.errorMessage['text_content'];
                  return errors
                }
              }
            },
    methods:{
        hasServerError(field){
        //eturn true;
        if (this.errorMessage.hasOwnProperty(field))
          return true;
        else {
          return false
        }
      }
    }

};
</script>
