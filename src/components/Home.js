import axios from 'axios';
import React, { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';
import styles from './Services.module.css';
import Header from './Header';

function Home() {
    const [itemData, setItemData] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [filter, setFilter] = useState(0);

    useEffect(() => {
        axios.get(`${process.env.REACT_APP_BASENAME}api/all_item`)
            .then(response => {
                setItemData(response.data);
                setIsLoading(false);
            });
    }, []);

    const filteredItems = filter === 1
        ? itemData.filter(item => item.item_price <= 50)
        : itemData;

    const renderItemCard = (item, index) => (
        <div className={`${styles.services__contentitem} ${styles.text__center}`} key={index}>
            <div>
                <img
                    alt={item.item_name}
                    src={`${process.env.REACT_APP_BASENAME}uploads/${item.item_image_dir}`}
                    className={styles.postimage}
                />
            </div>
            <h4 className={`${styles.section__title} ${styles.text}`}>{item.item_name}</h4>
            <p className={`${styles.para__text} ${styles.text__grey}`}>${item.item_price}</p>
            <p className={`${styles.para_text_smaller} ${styles.text__grey}`}>Views: {item.view_count}</p>
            <Link to={`/iteminfo?var=${item.item_id}`} className={`${styles.btn} ${styles.btn__blue}`}>More Info</Link>
        </div>
    );

    if (isLoading) return <p className={styles.loading}>Loading...</p>;

    return (
        <div className={styles.bg__whitesmoke}>
            <Header setItemData={setItemData} />
            
            <div className={`${styles.flex__center} ${styles.filter__section}`}>
                <button
                    className={`${styles.btn} ${filter === 1 ? styles.btn__active : styles.btn__blue}`}
                    onClick={() => setFilter(1)}
                >
                    $50 OR LOWER
                </button>
                <button
                    className={`${styles.btn} ${filter === 0 ? styles.btn__active : styles.btn__blue}`}
                    onClick={() => setFilter(0)}
                >
                    SHOW ALL
                </button>
            </div>

            <div className={`${styles.section__padding}`}>
                <div className={styles.container}>
                    <div className={`${styles.services__content} ${styles.grid}`}>
                        {filteredItems.map(renderItemCard)}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Home;
