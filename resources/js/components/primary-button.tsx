export default function PrimaryButton({ className = '', disabled, children, ...props }) {
    return (
        <button
            {...props}
            className={
                `text-white inline-flex items-center w-full h-14 justify-center bg-primaryBtn rounded-full font-semibold active:bg-gray-900 focus:outline-none focus:ring-2  ${
                    disabled && 'opacity-25'
                } ` + className
            }
            disabled={disabled}
        >
            {children}
        </button>
    );
}
