import PliziBaseAPI from './PliziBaseAPI.js'
import PliziAPIError from './PliziAPIError.js';

class PliziUsersAPI extends PliziBaseAPI{

    /**
     * получение детальной информации о юзере
     * @param {number|null} userId - если ID НЕ указан, то о текущем юзере
     * @returns {Object|null} - объект с данными юзера
     */
    async getUser(userId) {
        const path = (userId) ? `api/user/${userId}` : 'api/user';

        let response = await this.axios.get(path, this.authHeaders)
            .catch((error) => {
                this.checkIsTokenExpires(error, '$users.getUser');
                throw new PliziAPIError('$users.getUser', error.response);
            });

        if (200 === response.status) {
            return response.data;
        }

        return null;
    }


    /**
     * @deprecated
     * получение детальной информации о юзере
     * @param {number} id - числовой ID юзера
     * @returns {Object|null} - объект с данными юзера
     */
    async infoUser(id) {
        window.console.warn(`$users.infoUser - DEPRECATED`);
        let response = await this.__axios.get('' + id, this.__getAuthHeaders())
            .catch((error) => {
                this.__checkIsTokenExperis(error, `infoUser`);
                throw new PliziAPIError(`infoUser`, error.response);
            });

        if (200 === response.status) {
            return response.data.data;
        }

        return null;
    }


    /**
     * поиск по юзерам
     * @param sText - строка поиска
     * @returns {object[]|null} - коллеция с найденными юзерами или null как признак ошибки
     */
    async search(sText) {
        const sData = (sText + '').trim();

        let response = await this.axios.get('/api/user/search/' + sData, this.authHeaders)
            .catch((error) => {
                this.checkIsTokenExpires(error, `$users.search`);
                throw new PliziAPIError(`$users.search`, error.response);
            });

        if (response.status === 200) {
            return response.data.data.list;
        }

        return null;
    }

    /**
     * Смена email на странице редактирования профиля.
     *
     * @param {object} formData
     * @returns {object[]|null}
     */
    async changeEmail(formData) {
        let response = await this.axios.post('/api/user/email/change', formData, this.authHeaders)
            .catch((error) => {
                this.checkIsTokenExpires(error, `$users.changeEmail`);
                throw new PliziAPIError(`$users.changeEmail`, error.response);
            });

        if (response.status === 200) {
            return response.data;
        }

        return null;
    }

    /**
     * Подписаться на пользователя
     * @param userId
     * @returns {Promise<null|any>}
     */
    async follow(userId) {
        let response = await this.axios.post(`api/user/${userId}/follow`, {}, this.authHeaders)
            .catch((error) => {
                if (error.response.status === 422) {
                    return {
                        status: 422,
                        data: {
                            message: error.response.data.message
                        }
                    }
                } else {
                    this.checkIsTokenExpires(error, '$users.follow');
                    throw new PliziAPIError('$users.follow', error.response);
                }
            });

        if ([200, 422].includes(response.status)) {
            return response.data;
        }
        return null;
    }

    /**
     * Отписаться от пользователя
     * @param userId
     * @returns {Promise<null|any>}
     */
    async unFollow(userId) {
        let response = await this.axios.delete(`api/user/${userId}/follow`, this.authHeaders)
            .catch((error) => {
                if (error.response.status === 422) {
                    return {
                        status: 422,
                        data: {
                            message: error.response.data.message
                        }
                    }
                } else {
                    this.checkIsTokenExpires(error, '$users.unFollow');
                    throw new PliziAPIError('$users.unFollow', error.response);
                }
            });

        if ([200, 422].includes(response.status)) {
            return response.data;
        }
        return null;
    }

    /**
     * Список тех, на кого я подписан
     * @param limit
     * @param offset
     * @returns {Promise<null|*>}
     */
    async followList(limit, offset) {
        let path = 'api/user/follow/list';
        let qParams = '';

        if (limit && offset) {
            qParams = `?limit=${limit}&offset=${offset}`;
        }

        let response = await this.axios.get(path + qParams, this.authHeaders)
            .catch((error) => {
                this.checkIsTokenExpires(error, `$users.followList`);
                throw new PliziAPIError(`$users.followList`, error.response);
            });

        if (response.status === 200) {
            return response.data.data;
        }

        return null;
    }
}

export { PliziUsersAPI as default}
