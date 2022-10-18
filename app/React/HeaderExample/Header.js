import {Fragment} from 'react';
import classes from './Header.module.css';
import imagePath from '../../../public/assets/img.jpg';

const Header = () => {

    return (
        <Fragment>
            <header className={classes.main}>
                <div className={classes['header-img']}>
                    <img src={imagePath} />
                </div>
            </header>
        </Fragment>
    );
}

export default Header;