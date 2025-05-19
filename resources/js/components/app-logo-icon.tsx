import { ImgHTMLAttributes } from 'react';

export default function AppLogoIcon(props: ImgHTMLAttributes<HTMLImageElement>) {
    return (
        <img
            src="icons/app-logo.svg"
            alt="App Logo"
            {...props}
        />
    );
}
