async function addItem(o, product) {
    const res = await axios.put('/cart/item/' + product);

    return updateCount(o, res);
}

async function removeItem(o, product) {
    const res = await axios.delete('/cart/item/' + product);

    return updateCount(o, res);
}

function updateCount(o, res) {
    console.info(res.data);

    try {
        o.value(res.data);
    } catch (e) {
        o.innerText = res.data;
    }

    return res.data;
}

export default { addItem, removeItem }
