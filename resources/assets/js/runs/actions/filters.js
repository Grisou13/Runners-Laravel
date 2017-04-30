/**
 * Created by thomas_2 on 29.04.2017.
 */
export const filter = (filter_name, value) => {
    return {
        type: filter_name,
        payload: value
    }
}