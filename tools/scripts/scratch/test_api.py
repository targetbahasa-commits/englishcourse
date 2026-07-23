from gradio_client import Client
client = Client("https://6977f92a54fc7df0ce.gradio.live/")
print(client.view_api(print_info=False, return_format="dict"))
