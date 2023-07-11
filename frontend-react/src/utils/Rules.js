const Rules = [
    {
        field: "name",
        method: "isEmpty",
        validWhen: false,
        message: "Bạn chưa điền trường Name.",
    },
    {
        field: "email",
        method: "isEmpty",
        validWhen: false,
        message: "Bạn chưa điền trường Email.",
    },
    {
        field: 'email',
        method: 'isEmail',
        validWhen: true,
        message: 'Chưa đúng định dạng Email.',
    },
    {
        field: "phone",
        method: "isEmpty",
        validWhen: false,
        message: "Bạn chưa điền trường Phone.",
    },
];

export default Rules;