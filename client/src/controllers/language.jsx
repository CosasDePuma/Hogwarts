import EN from '../languages/en-US.json';
import ES from '../languages/es-ES.json';

export const defaultLang    = EN
export const messages       = { 'en': EN, 'es': ES }
export const language       =  'lang' in localStorage ? // Check if localStorage['lang'] is a valid lang
                                    localStorage.getItem('lang') : 
                                    navigator.language.split(/[-_]/)[0].toLowerCase();
export const setLang        = (val) => { localStorage.setItem('lang', val); window.location.reload(); }
