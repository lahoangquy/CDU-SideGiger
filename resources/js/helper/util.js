const axios = require('axios').default;

export default {
    options: Object.freeze(window.AirTaskerOpts),
    indexedFiles: [],
    cookie: {
        get: function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) == 0) {
                    return this.data.decode(c.substring(nameEQ.length, c.length));
                }
            }
            return null;
        },
        set: function (name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (this.data.encode(value)) + expires + "; path=/";
        },
        erase: function (name) {
            document.cookie = name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
        },
    },
    storage: {
        get: function (name) {
            return this.data.decode(window.localStorage.getItem(name))
        },
        set: function (name, value) {
            window.localStorage.setItem(name, this.data.encode(value))
        },
        erase: function (name) {
            window.localStorage.removeItem(name);
        },
    },
    event: {
        create(name, object) {
            let event = new CustomEvent(`MasterTool.${name}`, {
                bubbles: true,
                cancelable: true,
                detail: object
            });
            document.dispatchEvent(event);
        },
        listener(name, fn) {
            document.addEventListener(`MasterTool.${name}`, fn);
        },
        remove(name, fn) {
            document.removeEventListener(`MasterTool.${name}`, fn);
        },
    },
    data: {
        encode(object) {
            if (object == undefined || object == '') {
                object = {}
            }
            try {
                if (object == '') {
                    return object;
                }
                return Buffer.from(encodeURIComponent(JSON.stringify(object))).toString('base64');
            } catch (e) {
                return '';
            }
        },
        decode(str, def) {
            if (def == undefined) {
                def = {}
            }
            try {
                if (str == '') {
                    return def;
                }
                return JSON.parse(decodeURIComponent(Buffer.from(str, 'base64').toString('ascii')));
            } catch (e) {
                return {};
            }
        }
    },
    /* indexComponentFromFile(pattern, buildName) {
        let components = {}
        this.indexedFiles.filter(item => {
            return pattern.test(item)
        }).forEach((file) => {
            let fileArray = file.split('/')
            let required
            switch (fileArray.splice(0, 2)[1]) {
                case 'views':
                    required = require(`@/views/${fileArray.join('/')}`)
                    components[buildName(file)] = required.default || required
                    break
                case 'platforms':
                    required = require(`@/platforms/${fileArray.join('/')}`)
                    components[buildName(file)] = required.default || required
                    break
            }

        })
        return components;
    }, */
    randStr(length) {
        let characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        let result = ' ';
        const charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    },
    getObjectVal(object, keys) {
        if (Array.isArray(keys)) {
            let key = keys.shift();
            if (typeof object != "object" || object === null) {
                object = {};
            }
            if (keys.length > 0) {
                if (typeof object[key] == "object") {
                    return this.getObjectVal(object[key], keys);
                } else {
                    return null;
                }
            } else if (object[key] != undefined) {
                return object[key];
            } else {
                return null;
            }
        }
    },

    setObjectVal(object, keys, value) {
        if (Array.isArray(keys) && value != null) {
            let key = keys.shift()
            if (typeof object != "object" || object == null) {
                object = {}
            }
            if (typeof object[key] != "object" || object[key] == null) {
                object[key] = {}
            }
            if (keys.length > 0) {
                this.setObjectVal(object[key], keys, value)
            } else {
                object[key] = value
            }
        }
    },

    deepCopy(obj) {
        if (typeof obj !== "object" || obj === null || obj instanceof File || obj instanceof Blob) {
            return obj
        }
        if (obj instanceof Date) {
            return new Date(obj.getTime())
        }
        if (obj instanceof Array) {
            return obj.reduce((newArr, item, key) => {
                newArr[key] = this.deepCopy(item)
                return newArr
            }, [])
        }
        if (obj instanceof Object) {
            return Object.keys(obj).reduce((newObj, key) => {
                newObj[key] = this.deepCopy(obj[key])
                return newObj
            }, {})
        }
    },
    filter(obj, predicate) {
        return Object.keys(obj).filter(key => predicate(obj[key], key)).reduce((res, key) => (res[key] = obj[key], res), {});
    },
    map(obj, predicate) {
        return Object.keys(obj).reduce((res, key) => (res[key] = predicate(obj[key], key), res), {});
    },
    timestampToDate(time) {
        let date = new Date(time * 1000)
        return date.toLocaleDateString()
    },
    timestampToTime(time) {
        let date = new Date(time * 1000)
        return date.toLocaleTimeString()
    },
    timestampToDateTime(time, br) {
        if (br == undefined) {
            br = false
        }
        let date = new Date(time * 1000)
        return `${date.toLocaleTimeString()}${br === true ? "<br>" : ' '}<strong>${date.toLocaleDateString()}</strong>`
    },
    buildFormData(formData, data, parentKey) {
        if (data && typeof data === 'object' && !(data instanceof Date) && !(data instanceof File)) {
            Object.keys(data).forEach(key => {
                this.buildFormData(formData, data[key], parentKey ? `${parentKey}[${key}]` : key);
            });
        } else {
            const value = data == null ? '' : data;
            formData.append(parentKey, value);
        }
    },
    async post(uri, data, callback, config, args) {
        try {
            return new Promise((baseResolve, baseReject) => {
                args = Object.assign({
                    baseUrl: this.options.apiUrl
                }, args);

                let formData = new FormData();
                this.buildFormData(formData, data);

                config = Object.assign({
                    url: `${args.baseUrl}/${uri}`,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                }, config, {
                    method: "post",
                    data: formData
                })

                axios(config).then((response) => {
                    if (response.status < 400) {
                        if (typeof callback == 'object' && typeof callback.done == 'function') {
                            callback.done(response.data)
                        } else if (typeof callback == 'function') {
                            callback(response.data)
                        }
                        baseResolve(response.data)
                    }
                }).catch((error) => {
                    if (error.response && error.response.status === 419) {
                        window.location.href = '/login';
                    }
                    let response = Object.assign({}, typeof error.response == 'object' && typeof error.response.data == 'object' && error.response.data != null ? error.response.data : {})

                    if (typeof callback == 'object' && typeof callback.error == 'function') {
                        callback.error(response)
                    } else if (typeof callback == 'function') {
                        callback(response)
                    }

                    let msgHtml = '';
                    if (typeof response.errors == 'object') {
                        Object.values(response.errors).forEach((items) => {
                            if (typeof items == 'object') {
                                Object.values(items).forEach((item) => {
                                    msgHtml += '<p class="mb-0">' + item + '</p>'
                                })
                            }
                        })
                    } else {
                        msgHtml = response.msg || ''
                    }
                    if (msgHtml != '') {
                        Toast.fire(msgHtml, '', 'error');
                    }

                    baseReject(response)
                });
            });
        } catch (e) {
            console.log(e)
        }
    },
    async get(uri, data, callback, config, args) {
        try {
            return new Promise((baseResolve, baseReject) => {
                args = Object.assign({
                    baseUrl: this.options.apiUrl
                }, args);

                config = Object.assign({
                    url: `${args.baseUrl}/${uri}`,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                }, config, {
                    method: "get",
                    params: data
                })

                axios(config).then((response) => {
                    if (response.status == 200) {
                        if (typeof callback == 'object' && typeof callback.done == 'function') {
                            callback.done(response.data)
                        } else if (typeof callback == 'function') {
                            callback(response.data)
                        }
                        baseResolve(response.data)
                    }
                }).catch((error) => {
                    if (error.response && error.response.status === 419) {
                        window.location.href = '/login';
                    }
                    let response = Object.assign({}, typeof error.response == 'object' && typeof error.response.data == 'object' && error.response.data != null ? error.response.data : {})

                    if (typeof callback == 'object' && typeof callback.error == 'function') {
                        callback.error(response)
                    } else if (typeof callback == 'function') {
                        callback(response)
                    }
                    let msgHtml = '';
                    if (typeof response.errors == 'object') {
                        Object.values(response.errors).forEach((items) => {
                            if (typeof items == 'object') {
                                Object.values(items).forEach((item) => {
                                    msgHtml += '<p class="mb-0">' + item + '</p>'
                                })
                            }
                        })
                    } else {
                        msgHtml = response.msg || ''
                    }
                    if (msgHtml != '') {
                        Toast.fire(msgHtml, '', 'error');
                    }
                    baseReject(response)
                });
            });
        } catch (e) {
            console.log(e)
        }
    },
    sort(array) {
        array.sort((a, b) => {
            let priorityA, priorityB
            if (parseInt(a.priority) > 0) {
                priorityA = parseInt(a.priority)
            } else {
                priorityA = 10
            }
            if (parseInt(b.priority) > 0) {
                priorityB = parseInt(b.priority)
            } else {
                priorityB = 10
            }
            if (priorityA > priorityB) {
                return 1
            } else if (priorityA < priorityB) {
                return -1
            } else {
                return 0
            }
        })
        return array
    },

    convertNamePsr(str, fistUpCase) {
        if (fistUpCase == undefined) {
            fistUpCase = false
        }
        let regex = '([ |\\-|\\_]+[a-zA-Z\\p{M}])'
        if (fistUpCase == true) {
            regex = '(^([a-zA-Z\\p{M}]))|([ |\\-|\\_|\\.][a-zA-Z\\p{M}])'
        }
        return str.toLowerCase().replace(new RegExp(regex, 'g'), match => match.toUpperCase()).replace(/[ |\-|_]+/g, '')
    },
}
