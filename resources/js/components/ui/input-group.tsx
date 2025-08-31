
interface InputGroupProps {
    children: any
};

const InputGroup = ({ children } : InputGroupProps) => {
    return (
        <div className="flex flex-col gap-2">
            {children}
        </div>
    );
}

export default InputGroup;